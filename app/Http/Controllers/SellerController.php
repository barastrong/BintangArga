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
    /**
     * Show the seller registration form
     */
    public function create()
    {
        if (Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Anda sudah terdaftar sebagai penjual');
        }
        
        return view('sellers.register');
    }

    /**
     * Store a new seller profile
     */
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'nama_penjual' => 'required|string|max:255',
            'email_penjual' => 'required|email|unique:sellers,email_penjual',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if user already has a seller profile
        if (Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Anda sudah terdaftar sebagai penjual');
        }

        // Handle file upload if provided
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('sellers', 'public');
            $validatedData['foto_profil'] = $path;
        }

        // Create the seller profile with the authenticated user's ID
        $validatedData['user_id'] = Auth::id();
        
        // Note: nomor_seri will be automatically generated in the Seller model's boot method
        $seller = Seller::create($validatedData);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Pendaftaran penjual berhasil. Nomor seri Anda: ' . $seller->nomor_seri);
    }

    /**
     * Show seller dashboard
     */
    public function dashboard()
    {
        // Check if user is a seller
        if (!Auth::user()->isSeller()) {
            return redirect()->route('seller.register')
                ->with('error', 'Anda belum terdaftar sebagai penjual');
        }

        $seller = Auth::user()->seller;
        return view('sellers.dashboard', compact('seller'));
    }

    /**
     * Show edit form for seller profile
     */
    public function edit()
    {
        // Check if user is a seller
        if (!Auth::user()->isSeller()) {
            return redirect()->route('seller.register')
                ->with('error', 'Anda belum terdaftar sebagai penjual');
        }

        $seller = Auth::user()->seller;
        return view('sellers.edit', compact('seller'));
    }

    /**
     * Update seller profile
     */
    public function update(Request $request)
    {
        // Get the seller profile
        $seller = Auth::user()->seller;

        // Validate the input (nomor_seri is not editable)
        $validatedData = $request->validate([
            'nama_penjual' => 'required|string|max:255',
            'email_penjual' => 'required|email|unique:sellers,email_penjual,' . $seller->id,
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_telepon' => 'nullable|string|max:15', // Assuming phone number is a string
        ]);

        // Handle file upload if provided
        if ($request->hasFile('foto_profil')) {
            // Delete old image if exists
            if ($seller->foto_profil) {
                Storage::disk('public')->delete($seller->foto_profil);
            }
            
            $path = $request->file('foto_profil')->store('sellers', 'public');
            $validatedData['foto_profil'] = $path;
        }

        // Update the seller profile
        $seller->update($validatedData);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Profil penjual berhasil diperbarui');
    }
    
    /**
     * Show seller's products
     */
    public function products()
    {
        // Check if user is a seller
        if (!Auth::user()->isSeller()) {
            return redirect()->route('seller.register')
                ->with('error', 'Anda belum terdaftar sebagai penjual');
        }
        
        $seller = Auth::user()->seller;
        
        // Load products with category relationship
        $products = Product::with('category', 'city')
            ->where('seller_id', $seller->id)
            ->get();
        
        return view('sellers.products', compact('seller', 'products'));
    }
    
    /**
     * Show seller orders
     */
    public function orders()
    {
        // Check if user is a seller
        if (!Auth::user()->isSeller()) {
            return redirect()->route('seller.register')
                ->with('error', 'Anda belum terdaftar sebagai penjual');
        }
        
        $seller = Auth::user()->seller;
        
        // Get orders for the seller's products with all necessary relationships
        $orders = Purchase::with(['size', 'product', 'user'])
            ->where('seller_id', $seller->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('sellers.orders', compact('seller', 'orders'));
    }
    
    /**
     * Update order status
     */
    public function updateOrderStatus(Request $request, $orderId)
    {
        // Check if user is a seller
        if (!Auth::user()->isSeller()) {
            return redirect()->route('seller.register')
                ->with('error', 'Anda belum terdaftar sebagai penjual');
        }
        
        $seller = Auth::user()->seller;
        
        // Find the specific order by ID and seller
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

    /**
     * Delete seller profile
     */
    public function destroy($id)
    {
        // Check if user is authorized to delete this seller
        if (!Auth::user()->role === 'admin' && Auth::user()->seller->id != $id) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus profil penjual ini');
        }
        
        // Get the seller
        $seller = Seller::findOrFail($id);
        
        // Delete profile picture if exists
        if ($seller->foto_profil) {
            Storage::disk('public')->delete($seller->foto_profil);
        }
        
        // Delete related products
        $products = Product::where('seller_id', $id)->get();
        foreach ($products as $product) {
            // Delete product images if exist
            if ($product->gambar_produk) {
                Storage::disk('public')->delete($product->gambar_produk);
            }
            $product->delete();
        }
        
        // Delete the seller profile
        $seller->delete();
        
        // If the user deleted their own profile, redirect to home
        if (Auth::user()->seller && Auth::user()->seller->id == $id) {
            return redirect()->route('products.index')
                ->with('success', 'Profil penjual berhasil dihapus');
        }
        
        // If admin deleted a profile, redirect to admin dashboard or sellers list
        return redirect()->route('sellers.index')
            ->with('success', 'Profil penjual berhasil dihapus');
    }

    /**
     * Generate new serial number for existing seller (if needed)
     */
    public function regenerateSerial($id)
    {
        // Only admin can regenerate serial numbers
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