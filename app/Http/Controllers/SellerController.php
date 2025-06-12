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
        Seller::create($validatedData);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Pendaftaran penjual berhasil');
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

        // Validate the input
        $validatedData = $request->validate([
            'nama_penjual' => 'required|string|max:255',
            'email_penjual' => 'required|email|unique:sellers,email_penjual,' . $seller->id,
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
    
    public function products()
    {
        // Check if user is a seller
        if (!Auth::user()->isSeller()) {
            return redirect()->route('seller.register')
                ->with('error', 'Anda belum terdaftar sebagai penjual');
        }
        
        $seller = Auth::user()->seller;
        $products = Product::where('seller_id', $seller->id)->get();
        
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
        // Get orders for the seller's products
        $orders = Purchase::where('seller_id', $seller->id)->get();
        
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
        $order = Purchase::where('id', $orderId)
                         ->where('seller_id', $seller->id)
                         ->firstOrFail();
        
        // Validate the status
        $request->validate([
            'status' => 'required|in:process,completed',
        ]);
        
        // Update the order status
        $order->status = $request->status;
        $order->save();
        
        return redirect()->route('seller.orders')
            ->with('success', 'Status pesanan berhasil diperbarui');
    }
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
    }
}