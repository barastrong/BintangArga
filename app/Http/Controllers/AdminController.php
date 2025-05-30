<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;

class AdminController extends Controller
{
    
    public function index(){
        $users = User::paginate(10);
        return view('admin.index', ['users' => $users]);
    }
    
    /**
     * Search for users by name or email
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchUsers(Request $request)
    {
        // DB::enableQueryLog();
        
        $query = $request->input('query');
        
        $users = User::select('id', 'name', 'email', 'created_at', 'role')
                     ->where('name', 'LIKE', "%{$query}%")
                     ->orWhere('email', 'LIKE', "%{$query}%")
                     ->limit(50)
                     ->get();

        // dd(DB::getQueryLog());
        
        $formattedUsers = $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at_formatted' => $user->created_at ? $user->created_at->format('M d, Y') : 'Kosong',
                'role' => $user->role ?? 'user'
            ];
        });
        
        return response()->json([
            'users' => $formattedUsers
        ]);
    }
    
    public function products(){
        $products = Product::paginate(10);
        return view('admin.products', ['products' => $products]);
    }
    /**
     * Search for products by nama_barang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchProduct(Request $request)
    {
        $query = $request->input('query');
        
        $products = Product::where('nama_barang', 'LIKE', '%' . $query . '%')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'nama_barang' => $product->nama_barang,
                    'description' => $product->description,
                    'gambar' => $product->gambar,
                ];
            });
        
        return response()->json([
            'products' => $products
        ]);
    }

    public function viewUser($id){
        $user = User::findOrFail($id);
        return view('admin.user-detail', ['user' => $user]);
    }
    
    public function editUser($id){
        $user = User::findOrFail($id);
        return view('admin.user-edit', ['user' => $user]);
    }
    
    public function updateUser(Request $request, $id){
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:user,admin',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        if($request->password) {
            $validated = $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            $user->password = bcrypt($request->password);
        }
        
        $user->save();
        
        return redirect()->route('admin.index')->with('success', 'User updated successfully');
    }
    
    public function deleteUser($id){
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.index')->with('success', 'User deleted successfully');
    }

    public function purchases(){
    $purchases = Purchase::with(['user', 'product', 'size', 'seller'])->paginate(10);
    return view('admin.purchases', ['purchases' => $purchases]);
    }

    /**
     * Search for purchases
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchPurchases(Request $request)
    {
        $query = $request->input('query');
        
        $purchases = Purchase::with(['user', 'product', 'size', 'seller'])
            ->where(function($q) use ($query) {
                $q->where('id', 'LIKE', '%' . $query . '%')
                  ->orWhere('status', 'LIKE', '%' . $query . '%')
                  ->orWhere('payment_status', 'LIKE', '%' . $query . '%')
                  ->orWhere('total_price', 'LIKE', '%' . $query . '%')
                  ->orWhereHas('user', function($sq) use ($query) {
                      $sq->where('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('email', 'LIKE', '%' . $query . '%');
                  })
                  ->orWhereHas('product', function($sq) use ($query) {
                      $sq->where('nama_barang', 'LIKE', '%' . $query . '%');
                  });
            })
            ->get()
            ->map(function ($purchase) {
                return [
                    'id' => $purchase->id,
                    'user_name' => $purchase->user->name ?? 'Unknown',
                    'product_name' => $purchase->product->nama_barang ?? 'Unknown',
                    'quantity' => $purchase->quantity,
                    'total_price' => $purchase->total_price,
                    'status' => $purchase->status,
                    'payment_status' => $purchase->payment_status,
                    'status_pembelian' => $purchase->status_pembelian ?? '',
                    'created_at' => $purchase->created_at->format('M d, Y'),
                ];
            });
        
        return response()->json([
            'purchases' => $purchases
        ]);
    }

    public function viewPurchase($id){
        $purchase = Purchase::with(['user', 'product', 'size', 'seller'])->findOrFail($id);
        return view('admin.purchase-detail', ['purchase' => $purchase]);
    }

    public function deletePurchase($id){
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();
        
        return redirect()->route('admin.purchases')->with('success', 'Purchase deleted successfully');
    }
}