<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeliveryController extends Controller
{
    /**
     * Dashboard untuk delivery
     */
    public function dashboard()
    {
        // Cek apakah user sudah punya akun delivery
        if (!Auth::user()->delivery) {
            return redirect()->route('delivery.register')
                ->with('warning', 'Silakan daftar sebagai delivery terlebih dahulu');
        }

        $delivery = Auth::user()->delivery;
        
        // Statistik delivery
        $totalDeliveries = Purchase::where('delivery_id', $delivery->id)->count();
        $completedDeliveries = Purchase::where('delivery_id', $delivery->id)
            ->where('status_pengiriman', 'delivered')->count();
        $pendingDeliveries = Purchase::where('delivery_id', $delivery->id)
            ->where('status_pengiriman', 'shipping')->count();
        
        // Pesanan terbaru
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

    /**
     * Halaman register delivery
     */
    public function register()
    {
        // Jika sudah punya akun delivery, redirect ke dashboard
        if (Auth::user()->delivery) {
            return redirect()->route('delivery.dashboard');
        }

        return view('delivery.register');
    }

    /**
     * Proses register delivery
     */
    public function storeRegister(Request $request)
    {
        // Jika sudah punya akun delivery
        if (Auth::user()->delivery) {
            return redirect()->route('delivery.dashboard')
                ->with('info', 'Anda sudah terdaftar sebagai delivery');
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
            'user_id' => Auth::id()
        ];

        // Upload foto profile jika ada
        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('delivery_profiles', $filename, 'public');
            $data['foto_profile'] = $path;
        }

        Delivery::create($data);

        return redirect()->route('delivery.dashboard')
            ->with('success', 'Selamat! Anda berhasil terdaftar sebagai delivery');
    }

    /**
     * Daftar pesanan untuk delivery
     */
    public function orders(Request $request)
    {
        if (!Auth::user()->delivery) {
            return redirect()->route('delivery.register');
        }

        $delivery = Auth::user()->delivery;
        $status = $request->get('status_pengiriman', 'all');

        $query = Purchase::with(['user', 'product', 'seller'])
            ->where('delivery_id', $delivery->id);

        if ($status !== 'all') {
            $query->where('status_pengiriman', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('delivery.orders', compact('orders', 'status'));
    }

    /**
     * Detail pesanan
     */
    public function orderDetail($id)
    {
        if (!Auth::user()->delivery) {
            return redirect()->route('delivery.register');
        }

        $order = Purchase::with(['user', 'product', 'seller'])
            ->where('delivery_id', Auth::user()->delivery->id)
            ->findOrFail($id);

        return view('delivery.order-detail', compact('order'));
    }

    /**
     * Update status pesanan
     */
    public function updateOrderStatus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status_pengiriman' => 'required|in:picked_up,shipping,delivered'
        ]);

        // Cari pesanan berdasarkan delivery_id
        $order = Purchase::where('delivery_id', Auth::user()->delivery->id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }

        // Update status
        $order->status_pengiriman = $request->status_pengiriman;
        $order->save();

        // Pesan sukses
        $messages = [
            'picked_up' => 'Pesanan berhasil diambil',
            'shipping' => 'Pengiriman dimulai',
            'delivered' => 'Pesanan selesai dikirim'
        ];

        return redirect()->back()->with('success', $messages[$request->status_pengiriman]);
    }

    /**
     * Profil delivery
     */
    public function profile()
    {
        if (!Auth::user()->delivery) {
            return redirect()->route('delivery.register');
        }

        $delivery = Auth::user()->delivery;
        return view('delivery.profile', compact('delivery'));
    }

    /**
     * Edit profil delivery
     */
    public function editProfile()
    {
        if (!Auth::user()->delivery) {
            return redirect()->route('delivery.register');
        }

        $delivery = Auth::user()->delivery;
        return view('delivery.edit-profile', compact('delivery'));
    }

    /**
     * Update profil delivery
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::user()->delivery) {
            return redirect()->route('delivery.register');
        }

        $delivery = Auth::user()->delivery;

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

        // Upload foto profile baru jika ada
        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
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

    /**
     * Riwayat pengiriman
     */
    public function history()
    {
        if (!Auth::user()->delivery) {
            return redirect()->route('delivery.register');
        }

        $delivery = Auth::user()->delivery;
        
        $completedOrders = Purchase::with(['user', 'product', 'seller'])
            ->where('delivery_id', $delivery->id)
            ->where('status_pengiriman', 'delivered')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('delivery.history', compact('completedOrders'));
    }
}