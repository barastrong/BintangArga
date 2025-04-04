<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    
    public function index(){
        $users = User::latest()->paginate(10);
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
        $products = Product::latest()->paginate(10);
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
}