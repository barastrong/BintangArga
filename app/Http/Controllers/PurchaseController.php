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
            ->paginate(10);
            
        return view('purchases.index', compact('purchases'));
    }

    public function create(Request $request, Product $product, Size $size)
    {
        return view('purchases.create', compact('product', 'size'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'phone_number' => 'required|string',
            'description' => 'string'
        ]);

        try {
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
                'description' => $request->description,
                'shipping_address' => $request->shipping_address,
                'phone_number' => $request->phone_number
            ]);

            // Update stock
            $size->update([
                'stock' => $size->stock - $request->quantity
            ]);

            DB::commit();

            return redirect()->route('purchases.show', $purchase)
                ->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollback();
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

            // Return stock
            $size = $purchase->size;
            $size->update([
                'stock' => $size->stock + $purchase->quantity
            ]);

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
        if ($purchase->status !== 'pending') {
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
}