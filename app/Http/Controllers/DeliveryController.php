<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeliveryController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user->delivery) {
            return redirect()->route('delivery.register')
                ->with('info', 'Silakan daftar sebagai delivery terlebih dahulu.');
        }

        if ($user->delivery->is_proved == 0) {
            return redirect()->route('delivery.register')
                ->with('warning', 'Akun Anda sedang menunggu verifikasi dari admin.');
        }

        $delivery = $user->delivery;
        
        $totalDeliveries = Purchase::where('delivery_id', $delivery->id)->count();
        $completedDeliveries = Purchase::where('delivery_id', $delivery->id)
            ->where('status_pengiriman', 'delivered')->count();
        $pendingDeliveries = Purchase::where('delivery_id', $delivery->id)
            ->where('status_pengiriman', 'shipping')->count();
        
        $recentOrders = Purchase::with(['user', 'product'])
            ->where('delivery_id', $delivery->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('delivery.dashboard', compact(
            'delivery', 
            'totalDeliveries', 
            'completedDeliveries', 
            'pendingDeliveries', 
            'recentOrders'
        ));
    }

    public function register()
    {
        $user = Auth::user();
        
        if ($user->delivery && $user->delivery->is_proved == 1) {
            return redirect()->route('delivery.dashboard')
                ->with('info', 'Anda sudah terdaftar dan terverifikasi sebagai delivery');
        }

        return view('delivery.register');
    }

    public function storeRegister(Request $request)
    {
        $user = Auth::user();
        
        if ($user->delivery) {
            if ($user->delivery->is_proved == 1) {
                return redirect()->route('delivery.dashboard')
                    ->with('info', 'Anda sudah terdaftar dan terverifikasi sebagai delivery');
            } else {
                return redirect()->back()
                    ->with('warning', 'Akun delivery Anda sedang menunggu verifikasi admin');
            }
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15|unique:deliveries,no_telepon',
            'email' => 'required|email|unique:deliveries,email',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'is_proved' => 0,
            'user_id' => Auth::id()
        ];

        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('delivery_profiles', $filename, 'public');
            $data['foto_profile'] = $path;
        }

        Delivery::create($data);

        return redirect()->back()
            ->with('success', 'Pendaftaran berhasil! Tunggu verifikasi akun Anda oleh admin.');
    }

    public function orders(Request $request)
    {
        $user = Auth::user();

        if (!$user->delivery) {
            return redirect()->route('delivery.register')
                ->with('info', 'Silakan daftar sebagai delivery terlebih dahulu.');
        }

        if ($user->delivery->is_proved == 0) {
            return redirect()->route('delivery.register')
                ->with('warning', 'Akun Anda sedang menunggu verifikasi dari admin.');
        }

        $delivery = $user->delivery;
        $status = $request->get('status_pengiriman', 'all');

        $query = Purchase::with(['user', 'product', 'seller'])
            ->where('delivery_id', $delivery->id);

        if ($status !== 'all') {
            $query->where('status_pengiriman', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('delivery.orders', compact('orders', 'status'));
    }

    public function orderDetail($id)
    {
        $user = Auth::user();

        if (!$user->delivery) {
            return redirect()->route('delivery.register')
                ->with('info', 'Silakan daftar sebagai delivery terlebih dahulu.');
        }

        if ($user->delivery->is_proved == 0) {
            return redirect()->route('delivery.register')
                ->with('warning', 'Akun Anda sedang menunggu verifikasi dari admin.');
        }

        $order = Purchase::with(['user', 'product', 'seller'])
            ->where('delivery_id', Auth::user()->delivery->id)
            ->findOrFail($id);

        return view('delivery.order-detail', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status_pengiriman' => 'required|in:picked_up,shipping,delivered'
        ]);

        $order = Purchase::where('delivery_id', Auth::user()->delivery->id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }

        $order->status_pengiriman = $request->status_pengiriman;
        $order->save();

        $messages = [
            'picked_up' => 'Pesanan berhasil diambil',
            'shipping' => 'Pengiriman dimulai',
            'delivered' => 'Pesanan selesai dikirim'
        ];

        return redirect()->back()->with('success', $messages[$request->status_pengiriman]);
    }

    public function profile()
    {
        $user = Auth::user();

        if (!$user->delivery) {
            return redirect()->route('delivery.register')
                ->with('info', 'Silakan daftar sebagai delivery terlebih dahulu.');
        }

        if ($user->delivery->is_proved == 0) {
            return redirect()->route('delivery.register')
                ->with('warning', 'Akun Anda sedang menunggu verifikasi dari admin.');
        }

        $delivery = $user->delivery;
        return view('delivery.profile', compact('delivery'));
    }

    public function editProfile()
    {
        $user = Auth::user();

        if (!$user->delivery) {
            return redirect()->route('delivery.register')
                ->with('info', 'Silakan daftar sebagai delivery terlebih dahulu.');
        }

        if ($user->delivery->is_proved == 0) {
            return redirect()->route('delivery.register')
                ->with('warning', 'Akun Anda sedang menunggu verifikasi dari admin.');
        }

        $delivery = $user->delivery;
        return view('delivery.edit-profile', compact('delivery'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user->delivery) {
            return redirect()->route('delivery.register')
                ->with('info', 'Silakan daftar sebagai delivery terlebih dahulu.');
        }

        if ($user->delivery->is_proved == 0) {
            return redirect()->route('delivery.register')
                ->with('warning', 'Akun Anda sedang menunggu verifikasi dari admin.');
        }

        $delivery = $user->delivery;

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15|unique:deliveries,no_telepon,' . $delivery->id,
            'email' => 'required|email|unique:deliveries,email,' . $delivery->id,
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email
        ];

        if ($request->hasFile('foto_profile')) {
            if ($delivery->foto_profile) {
                Storage::disk('public')->delete($delivery->foto_profile);
            }

            $file = $request->file('foto_profile');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('delivery_profiles', $filename, 'public');
            $data['foto_profile'] = $path;
        }

        $delivery->update($data);

        return redirect()->route('delivery.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function history()
    {
        $user = Auth::user();

        if (!$user->delivery) {
            return redirect()->route('delivery.register')
                ->with('info', 'Silakan daftar sebagai delivery terlebih dahulu.');
        }

        if ($user->delivery->is_proved == 0) {
            return redirect()->route('delivery.register')
                ->with('warning', 'Akun Anda sedang menunggu verifikasi dari admin.');
        }

        $delivery = $user->delivery;
        
        $completedOrders = Purchase::with(['user', 'product', 'seller'])
            ->where('delivery_id', $delivery->id)
            ->where('status_pengiriman', 'delivered')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('delivery.history', compact('completedOrders'));
    }
}