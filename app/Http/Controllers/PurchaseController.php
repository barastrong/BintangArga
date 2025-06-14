<?php
// app/Http/Controllers/PurchaseController.php
namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Size;
use App\Models\Rating;
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
        ->get();
            
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
            ];
            
            // Add additional rules for direct purchase
            if ($request->status_pembelian === 'beli') {
                $rules = array_merge($rules, [
                    'shipping_address' => 'required|string',
                    'phone_number' => 'required|string',
                    'description' => 'required|string',
                ]);
            }
            
            $validatedData = $request->validate($rules);
            
            DB::beginTransaction();
    
            $size = Size::findOrFail($request->size_id);
            
            // Check stock availability
            if ($size->stock < $request->quantity) {
                throw new \Exception('Stock tidak mencukupi');
            }
    
            // Get product to retrieve seller_id
            $product = Product::findOrFail($request->product_id);
            $seller_id = $product->seller_id;
            
            // Calculate total price
            $total_price = $size->harga * $request->quantity;
    
            // Check if it's a cart item or direct purchase
            if ($request->status_pembelian === 'keranjang') {
                // Add to cart logic
                $existingCartItem = Purchase::where([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'size_id' => $request->size_id,
                    'status_pembelian' => 'keranjang',
                    'status' => 'keranjang'
                ])->first();
                
                if ($existingCartItem) {
                    // Update the existing cart item by adding the new quantity
                    $newQuantity = $existingCartItem->quantity + $request->quantity;
                    
                    // Verify that the new total quantity doesn't exceed available stock
                    if ($size->stock < $newQuantity) {
                        throw new \Exception('Total kuantitas melebihi stok yang tersedia');
                    }
                    
                    $existingCartItem->update([
                        'quantity' => $newQuantity,
                        'total_price' => $size->harga * $newQuantity
                    ]);
                    
                    $purchase = $existingCartItem;
                } else {
                    // Create new cart item if it doesn't exist
                    $purchase = Purchase::create([
                        'user_id' => Auth::id(),
                        'seller_id' => $seller_id,
                        'product_id' => $request->product_id,
                        'size_id' => $request->size_id,
                        'quantity' => $request->quantity,
                        'total_price' => $total_price,
                        'description' => $request->description ?? 'Added to cart',
                        'shipping_address' => $request->shipping_address ?? 'Temporary',
                        'phone_number' => $request->phone_number ?? 'Temporary',
                        'status_pembelian' => 'keranjang',
                        'status' => 'keranjang',
                        'payment_status' => 'unpaid',
                        'payment_method' => $request->payment_method ?? 'pending'
                    ]);
                }
                
                // Cart items don't reduce stock immediately
                $redirectRoute = 'cart.index';
                $successMessage = 'Item berhasil ditambahkan ke keranjang';
                
            } else {
                // Direct purchase logic - CREATE AS CART ITEM FIRST
                $purchase = Purchase::create([
                    'user_id' => Auth::id(),
                    'seller_id' => $seller_id,
                    'product_id' => $request->product_id,
                    'size_id' => $request->size_id,
                    'quantity' => $request->quantity,
                    'total_price' => $total_price,
                    'description' => $request->description ?? 'Direct purchase',
                    'shipping_address' => $request->shipping_address ?? 'Temporary',
                    'phone_number' => $request->phone_number ?? 'Temporary',
                    'status_pembelian' => 'beli', // Create as cart item first
                    'status' => 'beli', // Create as cart item first
                    'payment_status' => 'unpaid',
                    'payment_method' => $request->payment_method ?? 'pending'
                ]);
                
                // DON'T update stock here - let checkout handle it
                
                $successMessage = 'Produk siap untuk checkout';
            }
    
            DB::commit();
    
            // Handle AJAX response for cart
            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
    
            // For direct purchase, redirect to checkout with the item
            if ($request->status_pembelian === 'beli') {
                return redirect()->route('cart.checkout')
                    ->with('selectedItems', collect([$purchase]))
                    ->with('totalPrice', $total_price)
                    ->with('success', $successMessage);
            } else {
                return redirect()->route('cart.index')
                    ->with('success', $successMessage);
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
                'status' => 'cancelled',
                'payment_status' => 'cancelled',
            ]);

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Pesanan berhasil dibatalkan');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Complete purchase when user confirms delivery
     */
    public function complete(Purchase $purchase)
    {
        // Check authorization
        if (Auth::id() !== $purchase->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow completion if status is 'dikirim'
        if ($purchase->status !== 'dikirim') {
            return back()->with('error', 'Pesanan hanya dapat diselesaikan jika statusnya "Dikirim".');
        }

        try {
            DB::beginTransaction();

            // Update status to completed
            $purchase->update([
                'status' => 'completed'
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Pesanan telah berhasil diselesaikan. Anda dapat memberikan rating dan ulasan sekarang.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Cancel direct purchase items when user clicks back button in checkout
     */
    public function cancelDirectPurchase(Request $request)
    {
        // Validate the request
        $request->validate([
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:purchases,id'
        ]);

        try {
            DB::beginTransaction();

            // Get the purchases that belong to the current user and have status 'beli'
            $purchases = Purchase::whereIn('id', $request->item_ids)
                ->where('user_id', Auth::id())
                ->where('status_pembelian', 'beli')
                ->where('status', 'beli')
                ->with(['size'])
                ->get();

            if ($purchases->isEmpty()) {
                throw new \Exception('Tidak ada item yang dapat dibatalkan');
            }

            foreach ($purchases as $purchase) {
                // Return stock to the size if stock was reduced
                // (In your current implementation, stock is not reduced until checkout, 
                // but this is a safety measure)
                if ($purchase->size) {
                    $purchase->size->update([
                        'stock' => $purchase->size->stock + $purchase->quantity
                    ]);
                }

                // Delete the purchase record
                $purchase->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item pembelian langsung berhasil dibatalkan'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rate(Request $request, Purchase $purchase)
    {
        // Authorize - only the purchaser can rate
        if ($purchase->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Validate input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500'
        ]);
        
        try {
            $purchase->update([
                'rating' => $validated['rating'],
                'review' => $validated['review'],
                'has_been_rated' => true,
                'status' => 'selesai'
            ]);
            

            Rating::updateOrCreate(
                [
                    'product_id' => $purchase->product_id,
                    'user_id' => auth()->id(),
                ],
                [
                    'rating' => $validated['rating'],
                    'review' => $validated['review']
                ]
            );
            
            return redirect()->back()
                ->with('success', 'Terima kasih! Rating dan ulasan Anda telah disimpan.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
        // Check if we have selectedItems from session (direct purchase)
        $selectedItems = session('selectedItems');
        $totalPrice = session('totalPrice');
        
        if ($selectedItems && $totalPrice) {
            // Clear the session data
            session()->forget(['selectedItems', 'totalPrice']);
            return view('cart.checkout', compact('selectedItems', 'totalPrice'));
        }

        // Regular cart checkout
        $request->validate([
            'cart_items' => 'required|array',
            'cart_items.*' => 'exists:purchases,id',
        ]);

        $selectedItems = Purchase::whereIn('id', $request->cart_items)
            ->where('user_id', Auth::id())
            ->with(['product', 'size'])
            ->get();
            
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

    public function updateCartItem(Request $request, Purchase $purchase)
    {
        if (Auth::id() !== $purchase->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate request
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Make sure this is a cart item
        if ($purchase->status_pembelian !== 'keranjang' || $purchase->status !== 'keranjang') {
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

    public function processCheckout(Request $request) 
    {
        $request->validate([
            'cart_items' => 'required|array',
            'cart_items.*' => 'exists:purchases,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'shipping_address' => 'required|string',
            'phone_number' => 'required|string',
            'description' => 'nullable|string',
            'payment_method' => 'required|in:gopay,qris,dana,bank_transfer,',
            'total_with_tax' => 'nullable|numeric'
        ]);
        
        try {
            DB::beginTransaction();
            
            $cartItems = Purchase::whereIn('id', $request->cart_items)
                ->where('user_id', Auth::id())
                ->with(['size', 'product'])
                ->get();
            
            // Keep track of the first processed item for redirection
            $firstProcessedItem = null;
            
            foreach ($cartItems as $item) {
                $newQuantity = (int)$request->quantities[$item->id];
                
                if ($item->size->stock < $newQuantity) {
                    throw new \Exception("Stock untuk {$item->product->nama_barang} - {$item->size->size} tidak mencukupi. Tersedia: {$item->size->stock}");
                }
                
                $seller_id = $item->product->seller_id;
                
                // Reduce stock when processing checkout
                $item->size->update([
                    'stock' => $item->size->stock - $newQuantity
                ]);
                
                $basePrice = (int)($item->size->harga * $newQuantity);
                
                $tax = (int)($basePrice * 0.1);

                $totalWithTax = $basePrice + $tax;
            
                $item->update([
                    'status_pembelian' => 'beli',
                    'shipping_address' => $request->shipping_address,
                    'phone_number' => $request->phone_number,
                    'description' => $request->description,
                    'status' => 'pending',
                    'quantity' => $newQuantity,
                    'total_price' => $totalWithTax, // Now includes tax
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'paid',
                    'seller_id' => $seller_id
                ]);
                
                // Store the first item for redirection
                if ($firstProcessedItem === null) {
                    $firstProcessedItem = $item;
                }
            }
            
            DB::commit();
            
            if ($firstProcessedItem) {
                return redirect()->route('purchases.show', $firstProcessedItem)
                    ->with('success', 'Pesanan berhasil diproses');
            } else {
                return redirect()->route('purchases.index')
                    ->with('success', 'Pesanan berhasil diproses');
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}