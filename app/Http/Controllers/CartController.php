<?php
// CartController.php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()
            ->with(['product', 'size'])
            ->get();
            
        return view('cart.index', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $size = Size::findOrFail($request->size_id);
            
            // Check stock availability
            if ($size->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock tidak mencukupi'
                ]);
            }

            // Check if item already exists in cart
            $existingItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->where('size_id', $request->size_id)
                ->first();

            if ($existingItem) {
                // Update quantity if total doesn't exceed stock
                $newQuantity = $existingItem->quantity + $request->quantity;
                if ($newQuantity > $size->stock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Total quantity exceeds available stock'
                    ]);
                }
                
                $existingItem->update([
                    'quantity' => $newQuantity
                ]);
            } else {
                // Create new cart item
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'size_id' => $request->size_id,
                    'quantity' => $request->quantity
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding item to cart: ' . $e->getMessage()
            ]);
        }
    }

    public function removeFromCart(Cart $cart)
    {
        if (Auth::id() !== $cart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $cart->delete();
        
        return redirect()->back()
            ->with('success', 'Item removed from cart');
    }

    public function updateQuantity(Request $request, Cart $cart)
    {
        if (Auth::id() !== $cart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($request->quantity > $cart->size->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Requested quantity exceeds available stock'
            ]);
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully'
        ]);
    }
}