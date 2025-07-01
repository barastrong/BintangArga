<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    private function checkSellerVerification()
    {
        $user = Auth::user();
        
        if (!$user->seller) {
            return redirect()->route('seller.register')
                ->with('info', 'Silakan daftar sebagai penjual terlebih dahulu.');
        }
        
        if ($user->seller->is_proved != 1) {
            return redirect()->route('seller.register')
                ->with('warning', 'Akun Anda belum diverifikasi atau ditolak oleh admin.');
        }
        
        return null;
    }

    public function create()
    {
        if (Auth::user()->isSeller() && Auth::user()->seller->is_proved == 1) {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Anda sudah terdaftar sebagai penjual');
        }
        
        return view('sellers.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_penjual' => 'required|string|max:255',
            'email_penjual' => 'required|email|unique:sellers,email_penjual',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_telepon' => 'nullable|string|max:15',
        ]);

        if (Auth::user()->isSeller() && Auth::user()->seller->is_proved == 1) {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Anda sudah terdaftar sebagai penjual');
        }

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('sellers', 'public');
            $validatedData['foto_profil'] = $path;
        }

        $validatedData['user_id'] = Auth::id();
        $validatedData['is_proved'] = 0;

        $seller = Seller::create($validatedData);

        return redirect()->back()
            ->with('success', 'Pendaftaran penjual berhasil. Menunggu verifikasi admin. Nomor seri Anda: ' . $seller->nomor_seri);
    }

    public function dashboard()
    {
        $redirectResponse = $this->checkSellerVerification();
        if ($redirectResponse) {
            return $redirectResponse;
        }

        $seller = Auth::user()->seller;
        return view('sellers.dashboard', compact('seller'));
    }

    public function edit()
    {
        $redirectResponse = $this->checkSellerVerification();
        if ($redirectResponse) {
            return $redirectResponse;
        }

        $seller = Auth::user()->seller;
        return view('sellers.edit', compact('seller'));
    }

    public function update(Request $request)
    {
        $redirectResponse = $this->checkSellerVerification();
        if ($redirectResponse) {
            return $redirectResponse;
        }

        $seller = Auth::user()->seller;

        $validatedData = $request->validate([
            'nama_penjual' => 'required|string|max:255',
            'email_penjual' => 'required|email|unique:sellers,email_penjual,' . $seller->id,
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_telepon' => 'nullable|string|max:15',
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($seller->foto_profil) {
                Storage::disk('public')->delete($seller->foto_profil);
            }
            
            $path = $request->file('foto_profil')->store('sellers', 'public');
            $validatedData['foto_profil'] = $path;
        }

        $seller->update($validatedData);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Profil penjual berhasil diperbarui');
    }
    
    public function products()
    {
        $redirectResponse = $this->checkSellerVerification();
        if ($redirectResponse) {
            return $redirectResponse;
        }
        
        $seller = Auth::user()->seller;
        
        $products = Product::with('category', 'city')
            ->where('seller_id', $seller->id)
            ->get();
        
        return view('sellers.products', compact('seller', 'products'));
    }
    
    public function orders()
    {
        $redirectResponse = $this->checkSellerVerification();
        if ($redirectResponse) {
            return $redirectResponse;
        }
        
        $seller = Auth::user()->seller;
        
        $orders = Purchase::with(['size', 'product', 'user'])
            ->where('seller_id', $seller->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('sellers.orders', compact('seller', 'orders'));
    }
    
    public function updateOrderStatus(Request $request, $orderId)
    {
        $redirectResponse = $this->checkSellerVerification();
        if ($redirectResponse) {
            return $redirectResponse;
        }
        
        $seller = Auth::user()->seller;
        
        $order = Purchase::where('id', $orderId)
            ->where('seller_id', $seller->id)
            ->first();

        if (!$order) {
            return redirect()->route('seller.orders')
                ->with('error', 'Pesanan tidak ditemukan');
        }
        
        $request->validate([
            'status' => 'required|in:process,dikirim',
        ]);
        
        $order->status = $request->status;
        $order->save();
        
        return redirect()->route('seller.orders')
            ->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        if (!Auth::user()->role === 'admin' && Auth::user()->seller->is_proved != 1) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus profil penjual ini');
        }

        if (Auth::user()->seller && Auth::user()->seller->id == $id) {
            $redirectResponse = $this->checkSellerVerification();
            if ($redirectResponse) {
                return $redirectResponse;
            }
        }
        
        $seller = Seller::findOrFail($id);
        
        if ($seller->foto_profil) {
            Storage::disk('public')->delete($seller->foto_profil);
        }
        
        $products = Product::where('seller_id', $id)->get();
        foreach ($products as $product) {
            if ($product->gambar_produk) {
                Storage::disk('public')->delete($product->gambar_produk);
            }
            $product->delete();
        }
        
        $seller->delete();
        
        if (Auth::user()->seller && Auth::user()->seller->id == $id) {
            return redirect()->route('products.index')
                ->with('success', 'Profil penjual berhasil dihapus');
        }
        
        return redirect()->route('sellers.dashboard')
            ->with('success', 'Profil penjual berhasil dihapus');
    }

    public function regenerateSerial($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini');
        }

        $seller = Seller::findOrFail($id);
        $oldSerial = $seller->nomor_seri;
        $seller->nomor_seri = Seller::generateSerialNumber();
        $seller->save();

        return redirect()->back()
            ->with('success', 'Nomor seri berhasil diperbarui dari ' . $oldSerial . ' menjadi ' . $seller->nomor_seri);
    }
}