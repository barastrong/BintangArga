<?php
// app/Http/Controllers/PurchaseController.php
namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Size;
use App\Models\Rating;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception; // Import Exception class

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Auth::user()->purchases()
            ->with(['product', 'size', 'delivery'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('purchases.index', compact('purchases'));
    }

    public function store(Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || 
                  $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        try {
            $rules = [
                'product_id' => 'required|exists:products,id',
                'size_id' => 'required|exists:sizes,id',
                'quantity' => 'required|integer|min:1',
                'status_pembelian' => 'required|in:beli,keranjang',
            ];
            
            if ($request->status_pembelian === 'beli') {
                $rules = array_merge($rules, [
                    'shipping_address' => 'required|string',
                    'phone_number' => 'required|string',
                    'description' => 'nullable|string', // Dibuat nullable agar tidak wajib
                ]);
            }
            
            $validatedData = $request->validate($rules);
            
            DB::beginTransaction();
    
            $size = Size::findOrFail($request->size_id);
            
            if ($size->stock < $request->quantity) {
                throw new Exception('Stock tidak mencukupi');
            }
    
            $product = Product::findOrFail($request->product_id);
            $seller_id = $product->seller_id;
            $total_price = $size->harga * $request->quantity;
    
            if ($request->status_pembelian === 'keranjang') {
                $existingCartItem = Purchase::where([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'size_id' => $request->size_id,
                    'status_pembelian' => 'keranjang',
                    'status' => 'keranjang'
                ])->first();
                
                if ($existingCartItem) {
                    $newQuantity = $existingCartItem->quantity + $request->quantity;
                    if ($size->stock < $newQuantity) {
                        throw new Exception('Total kuantitas melebihi stok yang tersedia');
                    }
                    $existingCartItem->update([
                        'quantity' => $newQuantity,
                        'total_price' => $size->harga * $newQuantity
                    ]);
                    $purchase = $existingCartItem;
                } else {
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
                
                $successMessage = 'Item berhasil ditambahkan ke keranjang';
                
            } else { // Direct purchase
                $purchase = Purchase::create([
                    'user_id' => Auth::id(),
                    'seller_id' => $seller_id,
                    'product_id' => $request->product_id,
                    'size_id' => $request->size_id,
                    'quantity' => $request->quantity,
                    'total_price' => $total_price,
                    'description' => $request->description ?? 'Direct purchase',
                    'shipping_address' => $request->shipping_address,
                    'phone_number' => $request->phone_number,
                    'status_pembelian' => 'beli',
                    'status' => 'beli',
                    'payment_status' => 'unpaid',
                    'payment_method' => $request->payment_method ?? 'pending'
                ]);
                
                $successMessage = 'Produk siap untuk checkout';
            }
    
            DB::commit();
    
            if ($isAjax) {
                return response()->json(['success' => true, 'message' => $successMessage]);
            }
    
            if ($request->status_pembelian === 'beli') {
                // Untuk pembelian langsung, kita kirim data item ke halaman checkout via session
                return redirect()->route('cart.checkout')
                    ->with('direct_purchase_items', collect([$purchase]));
            } else {
                return redirect()->route('cart.index')->with('success', $successMessage);
            }
    
        } catch (Exception $e) {
            DB::rollback();
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        if (Auth::id() !== $purchase->user_id && !Auth::user()->isAdmin()) { // Admin bisa lihat
            abort(403, 'Unauthorized action.');
        }
        $purchase->load('delivery');
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
                throw new Exception('Pesanan tidak dapat dibatalkan');
            }

            // Kembalikan stok
            $size = $purchase->size;
            $size->increment('stock', $purchase->quantity);

            $purchase->update(['status' => 'cancelled', 'payment_status' => 'cancelled']);

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Pesanan berhasil dibatalkan');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function complete(Purchase $purchase)
    {
        if (Auth::id() !== $purchase->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($purchase->status !== 'dikirim') {
            return back()->with('error', 'Pesanan hanya dapat diselesaikan jika statusnya "Dikirim".');
        }

        try {
            $purchase->update(['status' => 'completed', 'delivered_at' => now()]);
            return redirect()->back()->with('success', 'Pesanan telah berhasil diselesaikan.');
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancelDirectPurchase(Request $request)
    {
        $request->validate(['item_ids' => 'required|array', 'item_ids.*' => 'exists:purchases,id']);
        try {
            DB::beginTransaction();
            $purchases = Purchase::whereIn('id', $request->item_ids)
                ->where('user_id', Auth::id())
                ->where('status_pembelian', 'beli')
                ->get();

            foreach ($purchases as $purchase) {
                $purchase->delete(); // Cukup hapus, karena stok belum dikurangi
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Item pembelian langsung berhasil dibatalkan']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function rate(Request $request, Purchase $purchase)
    {
        if ($purchase->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
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
                ['product_id' => $purchase->product_id, 'user_id' => auth()->id()],
                ['rating' => $validated['rating'], 'review' => $validated['review']]
            );
            
            return redirect()->back()->with('success', 'Terima kasih! Rating dan ulasan Anda telah disimpan.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function viewCart() 
    {
        $cartItems = Auth::user()->purchases()
            ->where('status', 'keranjang')
            ->with(['product', 'size'])
            ->get();
        return view('cart.index', compact('cartItems'));
    }

    public function removeFromCart(Purchase $purchase)
    {
        if (Auth::id() !== $purchase->user_id || $purchase->status !== 'keranjang') {
            abort(403, 'Unauthorized action.');
        }
        $purchase->delete();
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
    }

       public function checkoutFromCart(Request $request)
    {
        $selectedItems = collect(); // Inisialisasi sebagai collection kosong

        // Skenario 1: Checkout dari halaman Keranjang (menggunakan method POST)
        if ($request->isMethod('post')) {
            $request->validate([
                'cart_items' => 'required|array',
                'cart_items.*' => 'exists:purchases,id',
            ]);

            $selectedItems = Purchase::whereIn('id', $request->cart_items)
                ->where('user_id', Auth::id())
                ->with(['product', 'size'])
                ->get();
        }
        // Skenario 2: Checkout dari "Beli Langsung" (menggunakan method GET dengan data session)
        elseif (session()->has('direct_purchase_items')) {
            $selectedItems = session('direct_purchase_items');
            
            // PENTING: Hapus session setelah datanya diambil agar tidak digunakan lagi
            session()->forget('direct_purchase_items');
        }

        // Jika setelah semua pengecekan tetap tidak ada item
        // (misalnya akses URL checkout langsung tanpa memilih barang)
        if ($selectedItems->isEmpty()) {
            // Redirect ke halaman keranjang dengan pesan error. INI MEMUTUS LOOP.
            return redirect()->route('cart.index')->with('error', 'Tidak ada item yang dipilih untuk checkout. Silakan pilih dari keranjang Anda.');
        }
        
        // Hitung total harga dari item yang valid
        $totalPrice = $selectedItems->sum('total_price');
        
        // Tampilkan halaman checkout dengan data yang benar
        return view('cart.checkout', compact('selectedItems', 'totalPrice'));
    }
    public function getCartCount()
    {
        $count = Auth::user()->purchases()->where('status', 'keranjang')->count();
        return response()->json(['count' => $count]);
    }

    public function updateCartItem(Request $request, Purchase $purchase)
    {
        if (Auth::id() !== $purchase->user_id || $purchase->status !== 'keranjang') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate(['quantity' => 'required|integer|min:1']);

        if ($purchase->size->stock < $validated['quantity']) {
            return response()->json(['error' => 'Stock tidak mencukupi', 'available_stock' => $purchase->size->stock], 400);
        }

        $purchase->update([
            'quantity' => $validated['quantity'],
            'total_price' => $purchase->size->harga * $validated['quantity']
        ]);

        return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
    }

    public function processCheckout(Request $request) 
    {
        $request->validate([
            'cart_items' => 'required|array',
            'cart_items.*' => 'exists:purchases,id',
            'shipping_address' => 'required|string',
            'phone_number' => 'required|string',
            'description' => 'nullable|string',
            'payment_method' => 'required|in:gopay,qris,dana,bank_transfer',
        ]);
        
        try {
            DB::beginTransaction();
            
            $itemsToProcess = Purchase::whereIn('id', $request->cart_items)
                ->where('user_id', Auth::id())
                ->with(['size', 'product'])
                ->get();

            if ($itemsToProcess->isEmpty()) {
                throw new Exception("Tidak ada item valid untuk diproses.");
            }
            
            foreach ($itemsToProcess as $item) {
                if ($item->size->stock < $item->quantity) {
                    throw new Exception("Stock untuk {$item->product->nama_barang} - {$item->size->size} tidak mencukupi. Tersedia: {$item->size->stock}");
                }
                
                $randomDelivery = Delivery::inRandomOrder()->first();
                if (!$randomDelivery) {
                    throw new Exception("Tidak ada kurir yang tersedia saat ini.");
                }
                
                $item->size->decrement('stock', $item->quantity);
            
                $item->update([
                    'status_pembelian' => 'beli',
                    'shipping_address' => $request->shipping_address,
                    'phone_number' => $request->phone_number,
                    'description' => $request->description,
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'paid',
                    'delivery_id' => $randomDelivery->id,
                    'assigned_to_delivery_at' => now()
                ]);
            }
            
            DB::commit();
            
            // Redirect ke halaman daftar pesanan setelah berhasil
            return redirect()->route('purchases.index')
                ->with('success', 'Pesanan Anda berhasil dibuat dan sedang menunggu konfirmasi penjual.');
            
        } catch (Exception $e) {
            DB::rollback();
            
            // =================================================================
            // PERBAIKAN UTAMA: Redirect ke halaman keranjang, bukan 'back()'.
            // Ini akan memutus loop redirect jika terjadi error.
            // =================================================================
            return redirect()->route('cart.index')
                ->with('error', 'Gagal memproses pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }
}