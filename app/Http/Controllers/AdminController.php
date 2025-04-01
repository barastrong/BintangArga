<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    
    public function index(){
        $users = User::latest()->paginate(10);
        return view('admin.index', ['users' => $users]);
    }
    
    public function products(){
        $products = Product::latest()->paginate(10);
        return view('admin.products', ['products' => $products]);
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