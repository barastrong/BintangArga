<?php
// app/Http/Controllers/PurchaseController.php
namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Auth::user()->purchases()
        ->with(['product', 'size'])
        ->orderBy('created_at', 'desc')
        ->get(); // Changed to get() to allow filtering by status in the view
            
    return view('purchases.index', compact('purchases'));
    }

    public function store(Request $request)
    {
        // For AJAX requests, make sure to return JSON responses
        $isAjax = $request->ajax() || $request->wantsJson() || 
                  $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        try {
            // Validation rules
            $rules = [
                'product_id' => 'required|exists:products,id',
                'size_id' => 'required|exists:sizes,id',
                'quantity' => 'required|integer|min:1',
                'status_pembelian' => 'required|in:beli,keranjang',
                'payment_method' => 'nullable|string',
            ];
            
            // Add additional rules for direct purchase
            if ($request->status_pembelian === 'beli') {
                $rules = array_merge($rules, [
                    'shipping_address' => 'required|string',
                    'phone_number' => 'required|string',
                    'description' => 'required|string',
                ]);
            }
            
            // Validate the request
            $validatedData = $request->validate($rules);
            
            DB::beginTransaction();
    
            $size = Size::findOrFail($request->size_id);
            
            // Check stock availability
            if ($size->stock < $request->quantity) {
                throw new \Exception('Stock tidak mencukupi');
            }
    
            // Calculate total price
            $total_price = $size->harga * $request->quantity;
    
            // Create purchase
            $purchase = Purchase::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'size_id' => $request->size_id,
                'quantity' => $request->quantity,
                'total_price' => $total_price,
                'description' => $request->description ?? 'Added to cart',
                'shipping_address' => $request->shipping_address ?? 'Temporary',
                'phone_number' => $request->phone_number ?? 'Temporary',
                'status_pembelian' => $request->status_pembelian,
                'status' => $request->status_pembelian === 'keranjang' ? 'keranjang' : 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method ?? 'pending'
            ]);
    
            // Only update stock if it's a direct purchase, not cart
            if ($request->status_pembelian === 'beli') {
                // Update stock
                $size->update([
                    'stock' => $size->stock - $request->quantity
                ]);
            }
    
            DB::commit();
    
            // Handle AJAX response for cart
            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil ditambahkan ke keranjang'
                ]);
            }
    
            // Handle redirect based on purchase type
            if ($request->status_pembelian === 'keranjang') {
                return redirect()->route('cart.index')
                    ->with('success', 'Item berhasil ditambahkan ke keranjang');
            } else {
                return redirect()->route('purchases.show', $purchase)
                    ->with('success', 'Pesanan berhasil dibuat');
            }
    
        } catch (\Exception $e) {
            DB::rollback();
            
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        if (Auth::id() !== $purchase->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('purchases.show', compact('purchase'));
    }

    public function cancel(Purchase $purchase)
    {
        if (Auth::id() !== $purchase->user_id) {
            abort(403, 'Unauthorized action.');
        }
        try {
            DB::beginTransaction();

            if ($purchase->status !== 'pending') {
                throw new \Exception('Pesanan tidak dapat dibatalkan');
            }

            // Return stock if it's a direct purchase
            if ($purchase->status_pembelian === 'beli') {
                $size = $purchase->size;
                $size->update([
                    'stock' => $size->stock + $purchase->quantity
                ]);
            }

            // Update purchase status
            $purchase->update([
                'status' => 'cancelled'
            ]);

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Pesanan berhasil dibatalkan');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rate(Request $request, Purchase $purchase)
    {
        // Authorize - only the purchaser can rate
        if ($purchase->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Validate only completed purchases can be rated
        if ($purchase->status !== 'completed') {
            return redirect()->back()
                ->with('error', 'Hanya pembelian yang telah selesai yang dapat diberi rating.');
        }
        
        // Validate input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500'
        ]);
        
        // Save the rating and review
        $purchase->update([
            'rating' => $validated['rating'],
            'review' => $validated['review']
        ]);
        
        return redirect()->back()
            ->with('success', 'Terima kasih! Rating dan ulasan Anda telah disimpan.');
    }

    public function viewCart() 
    {
        $cartItems = Auth::user()->purchases()
            ->where('status_pembelian', 'keranjang')
            ->where('status', 'keranjang')
            ->with(['product', 'size'])
            ->get();
            
        return view('cart.index', compact('cartItems'));
    }

    public function removeFromCart(Purchase $purchase)
    {
        if (Auth::id() !== $purchase->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($purchase->status_pembelian !== 'keranjang') {
            abort(400, 'This item is not in a cart.');
        }

        $purchase->delete();
        
        return redirect()->back()
            ->with('success', 'Item berhasil dihapus dari keranjang');
    }

    public function checkoutFromCart(Request $request)
    {
        $request->validate([
            'cart_items' => 'required|array',
            'cart_items.*' => 'exists:purchases,id',
        ]);
    
        // Display checkout form with selected items
        $selectedItems = Purchase::whereIn('id', $request->cart_items)
            ->where('user_id', Auth::id())
            ->where('status_pembelian', 'keranjang')
            ->where('status', 'keranjang')
            ->with(['product', 'size'])
            ->get();
            
        // Calculate totals
        $totalPrice = $selectedItems->sum(function($item) {
            return $item->quantity * $item->size->harga;
        });
        
        return view('cart.checkout', compact('selectedItems', 'totalPrice'));
    }

    public function getCartCount()
    {
        $count = Auth::user()->purchases()
            ->where('status_pembelian', 'keranjang')
            ->where('status', 'keranjang')
            ->count();
            
        return response()->json(['count' => $count]);
    }

// Add these methods to your PurchaseController

public function updateCartItem(Request $request, Purchase $purchase)
{
    // Check authorization
    if (Auth::id() !== $purchase->user_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Validate request
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    // Make sure this is a cart item
    if ($purchase->status_pembelian !== 'keranjang' || $purchase->status !== 'pending') {
        return response()->json(['error' => 'This is not a cart item'], 400);
    }

    // Check stock availability
    if ($purchase->size->stock < $validated['quantity']) {
        return response()->json([
            'error' => 'Stock tidak mencukupi',
            'available_stock' => $purchase->size->stock
        ], 400);
    }

    // Update quantity and total price
    $purchase->update([
        'quantity' => $validated['quantity'],
        'total_price' => $purchase->size->harga * $validated['quantity']
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Quantity updated successfully'
    ]);
}

// Add this to your PurchaseController

public function processCheckout(Request $request)
{
    $request->validate([
        'cart_items' => 'required|array',
        'status' => 'pending',
        'cart_items.*' => 'exists:purchases,id',
        'quantities' => 'required|array',
        'quantities.*' => 'integer|min:1',
        'shipping_address' => 'required|string',
        'phone_number' => 'required|string',
        'payment_method' => 'required|in:gopay,qris,nyicil' // Validate payment method
    ]);

    try {
        DB::beginTransaction();

        $cartItems = Purchase::whereIn('id', $request->cart_items)
            ->where('user_id', Auth::id())
            ->where('status_pembelian', 'keranjang')
            ->where('status', 'pending')
            ->with('size')
            ->get();

        foreach ($cartItems as $item) {
            // Get the updated quantity from the request
            $newQuantity = $request->quantities[$item->id] ?? $item->quantity;
            
            // Check stock availability
            if ($item->size->stock < $newQuantity) {
                throw new \Exception("Stock untuk {$item->product->nama_barang} - {$item->size->size} tidak mencukupi");
            }

            // Update stock
            $item->size->update([
                'stock' => $item->size->stock - $newQuantity
            ]);

            // Update purchase with the new quantity and payment method
            $item->update([
                'status_pembelian' => 'beli',
                'shipping_address' => $request->shipping_address,
                'phone_number' => $request->phone_number,
                'status'=>$request->status,
                'quantity' => $newQuantity,
                'total_price' => $item->size->harga * $newQuantity,
                'payment_method' => $request->payment_method // Store the selected payment method
            ]);
        }

        DB::commit();

        return redirect()->route('purchases.index')
            ->with('success', 'Pesanan berhasil diproses');

    } catch (\Exception $e) {
        DB::rollback();
        return back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
}
}