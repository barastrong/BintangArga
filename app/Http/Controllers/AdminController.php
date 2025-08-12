<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Province;
use App\Models\City;
use App\Models\Seller;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Purchase;

class AdminController extends Controller
{
    
    public function index(){
        $users = User::paginate(10);
        return view('admin.index', ['users' => $users]);
    }
    
    /**
     * Search for users by name, email, or role
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        
        $users = User::select('id', 'name', 'email', 'created_at', 'role', 'google_id', 'github_id', 'profile_image')
                     ->where('name', 'LIKE', "%{$query}%")
                     ->orWhere('email', 'LIKE', "%{$query}%")
                     ->orWhere('role', 'LIKE', "%{$query}%")
                     ->limit(50)
                     ->get();
        
        $formattedUsers = $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at_formatted' => $user->created_at ? $user->created_at->format('M d, Y') : 'Kosong',
                'role' => $user->role ?? 'user',
                'google_id' => $user->google_id,
                'github_id' => $user->github_id,
                'profile_image' => $user->profile_image
            ];
        });
        
        return response()->json([
            'users' => $formattedUsers
        ]);
    }
    
    
    public function products(){
        $products = Product::with(['category', 'seller', 'province', 'city', 'sizes'])
                          ->paginate(10);
        return view('admin.products', ['products' => $products]);
    }

    /**
     * Search for products by nama_barang, category, seller, or location
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchProduct(Request $request)
    {
        $query = $request->input('query');
        
        $products = Product::with(['category', 'seller', 'province', 'city', 'sizes'])
            ->where(function($q) use ($query) {
                $q->where('nama_barang', 'LIKE', '%' . $query . '%')
                  ->orWhere('description', 'LIKE', '%' . $query . '%')
                  ->orWhere('lokasi', 'LIKE', '%' . $query . '%')
                  ->orWhereHas('category', function($sq) use ($query) {
                      $sq->where('name', 'LIKE', '%' . $query . '%');
                  })
                  ->orWhereHas('seller', function($sq) use ($query) {
                      $sq->where('name', 'LIKE', '%' . $query . '%');
                  })
                  ->orWhereHas('province', function($sq) use ($query) {
                      $sq->where('name', 'LIKE', '%' . $query . '%');
                  })
                  ->orWhereHas('city', function($sq) use ($query) {
                      $sq->where('name', 'LIKE', '%' . $query . '%');
                  });
            })
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'nama_barang' => $product->nama_barang,
                    'description' => $product->description,
                    'gambar' => $product->gambar,
                    'category_name' => $product->category->name ?? 'No Category',
                    'seller_name' => $product->seller->name ?? 'No Seller',
                    'location' => $product->lokasi,
                    'province_name' => $product->province->name ?? '',
                    'city_name' => $product->city->name ?? '',
                    'min_price' => $product->min_price ?? 0,
                    'max_price' => $product->max_price ?? 0,
                    'total_stock' => $product->total_stock ?? 0,
                    'created_at' => $product->created_at->format('M d, Y'),
                ];
            });
        
        return response()->json([
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new product
     */
    public function createProduct()
    {
        $categories = Category::all();
        $provinces = Province::all();
        $sellers = Seller::all();
        
        return view('admin.product-create', compact('categories', 'provinces', 'sellers'));
    }

    /**
     * Store a newly created product in storage
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_barang' => 'required|string|max:255',
            'description' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alamat_lengkap' => 'required|string',
            'lokasi' => 'required|string',
            'seller_id' => 'required|exists:sellers,id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id'
        ]);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified product
     */
    public function viewProduct($id)
    {
        $product = Product::with(['category', 'seller', 'province', 'city', 'sizes', 'ratings.user'])
                         ->findOrFail($id);
        return view('admin.product-detail', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified product
     */
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $provinces = Province::all();
        $cities = City::where('province_id', $product->province_id)->get();
        $sellers = Seller::all();
        
        return view('admin.product-edit', compact('product', 'categories', 'provinces', 'cities', 'sellers'));
    }

    /**
     * Update the specified product in storage
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_barang' => 'required|string|max:255',
            'description' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alamat_lengkap' => 'required|string',
            'lokasi' => 'required|string',
            'seller_id' => 'required|exists:sellers,id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id'
        ]);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified product from storage
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete associated image
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }
        
        $product->delete();
        
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }

    /**
     * Get cities by province (for AJAX)
     */
    public function getCitiesByProvince($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->get();
        return response()->json($cities);
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
     */
    public function searchPurchases(Request $request)
    {
        $query = $request->input('query');
        
        $purchases = Purchase::with(['user', 'product', 'size', 'seller'])
            ->where(function($q) use ($query) {
                $q->where('id', 'LIKE', '%' . $query . '%')
                ->orWhere('status', 'LIKE', '%' . $query . '%')
                ->orWhere('status_pengiriman', 'LIKE', '%' . $query . '%')
                ->orWhere('payment_method', 'LIKE', '%' . $query . '%')
                ->orWhere('payment_status', 'LIKE', '%' . $query . '%')
                ->orWhere('status_pembelian', 'LIKE', '%' . $query . '%')
                ->orWhere('total_price', 'LIKE', '%' . $query . '%')
                ->orWhere('phone_number', 'LIKE', '%' . $query . '%')
                ->orWhere('shipping_address', 'LIKE', '%' . $query . '%')
                ->orWhereHas('user', function($sq) use ($query) {
                    $sq->where('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('email', 'LIKE', '%' . $query . '%');
                })
                ->orWhereHas('product', function($sq) use ($query) {
                    $sq->where('nama_barang', 'LIKE', '%' . $query . '%');
                })
                ->orWhereHas('seller', function($sq) use ($query) {
                    $sq->where('nama_penjual', 'LIKE', '%' . $query . '%');
                })
                ->orWhereHas('size', function($sq) use ($query) {
                    $sq->where('size', 'LIKE', '%' . $query . '%');
                });
            })
            ->get()
            ->map(function ($purchase) {
                return [
                    'id' => $purchase->id,
                    'user_name' => $purchase->user->name ?? 'Unknown',
                    'product_name' => $purchase->product->nama_barang ?? 'Unknown',
                    'seller_name' => $purchase->seller->name ?? 'Unknown',
                    'size_name' => $purchase->size->size ?? 'No Size',
                    'quantity' => $purchase->quantity,
                    'total_price' => $purchase->total_price,
                    'status' => $purchase->status,
                    'status_pengiriman' => $purchase->status_pengiriman ?? 'pending',
                    'payment_method' => $purchase->payment_method ?? 'Unknown',
                    'payment_status' => $purchase->payment_status,
                    'status_pembelian' => $purchase->status_pembelian ?? 'beli',
                    'phone_number' => $purchase->phone_number ?? '',
                    'shipping_address' => $purchase->shipping_address ?? '',
                    'description' => $purchase->description ?? '',
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

    public function sellers()
    {
        $sellers = Seller::with(['user'])
                        ->withCount('products')
                        ->paginate(10);
        return view('admin.sellers', ['sellers' => $sellers]);
    }

    /**
     * Search for sellers by name, email, serial number, or phone
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchSellers(Request $request)
    {
        $query = $request->input('query');
        
        $sellers = Seller::with(['user'])
                        ->withCount('products')
                        ->where('nama_penjual', 'LIKE', "%{$query}%")
                        ->orWhere('email_penjual', 'LIKE', "%{$query}%")
                        ->orWhere('nomor_seri', 'LIKE', "%{$query}%")
                        ->orWhere('no_telepon', 'LIKE', "%{$query}%")
                        ->orWhereHas('user', function($q) use ($query) {
                            $q->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('email', 'LIKE', "%{$query}%");
                        })
                        ->limit(50)
                        ->get();
        
        $formattedSellers = $sellers->map(function($seller) {
            return [
                'id' => $seller->id,
                'nama_penjual' => $seller->nama_penjual,
                'email_penjual' => $seller->email_penjual,
                'nomor_seri' => $seller->nomor_seri,
                'no_telepon' => $seller->no_telepon,
                'foto_profil' => $seller->foto_profil,
                'user_name' => $seller->user ? $seller->user->name : null,
                'products_count' => $seller->products_count,
                'created_at_formatted' => $seller->created_at ? $seller->created_at->format('M d, Y') : 'Unknown',
            ];
        });
        
        return response()->json([
            'sellers' => $formattedSellers
        ]);
    }


    /**
     * Display the specified seller
     */
    public function viewSeller($id)
    {
        $seller = Seller::with(['user', 'products.category', 'products.sizes'])
                    ->withCount('products')
                    ->findOrFail($id);
        return view('admin.seller-detail', ['seller' => $seller]);
    }

    /**
     * Remove the specified seller from storage
     */
    public function deleteSeller($id)
    {
        $seller = Seller::findOrFail($id);
        
        // Delete associated profile image
        if ($seller->foto_profil) {
            Storage::disk('public')->delete($seller->foto_profil);
        }
        
        // Note: Products associated with this seller will need to be handled
        // You might want to reassign them or delete them based on your business logic
        
        $seller->delete();
        
        return redirect()->route('admin.sellers')->with('success', 'Seller deleted successfully');
    }

    /**
     * Display delivery management page
     */
    public function deliveries()
    {
        $deliveries = Delivery::withCount('purchases')
                        ->paginate(10);
        return view('admin.deliveries', ['deliveries' => $deliveries]);
    }

    /**
     * Search for deliveries by name, email, serial number, or phone
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchDeliveries(Request $request)
    {
        $query = $request->input('query');
    
        $deliveries = Delivery::withCount('purchases')
                        ->where('nama', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%")
                        ->orWhere('delivery_serial', 'LIKE', "%{$query}%")
                        ->orWhere('no_telepon', 'LIKE', "%{$query}%")
                        ->limit(50)
                        ->get();
    
        $formattedDeliveries = $deliveries->map(function($delivery) {
            return [
                'id' => $delivery->id,
                'nama' => $delivery->nama,
                'email' => $delivery->email,
                'delivery_serial' => $delivery->delivery_serial,
                'no_telepon' => $delivery->no_telepon,
                'foto_profile' => $delivery->foto_profile,
                'purchases_count' => $delivery->purchases_count ?? 0,
                'created_at_formatted' => $delivery->created_at ? $delivery->created_at->format('M d, Y') : 'Unknown',
            ];
        });
    
        return response()->json([
            'deliveries' => $formattedDeliveries
        ]);
    }

    /**
     * Display the specified delivery
     */
    public function viewDelivery($id)
    {
        $delivery = Delivery::with(['purchases.user', 'purchases.product', 'purchases.seller'])
                    ->withCount('purchases')
                    ->findOrFail($id);
        return view('admin.delivery-detail', ['delivery' => $delivery]);
    }

    /**
     * Remove the specified delivery from storage
     */
    public function deleteDelivery($id)
    {
        $delivery = Delivery::findOrFail($id);
    
        // Check if delivery has active purchases
        $activePurchases = $delivery->purchases()->whereIn('status_pengiriman', ['pending', 'processing', 'shipped'])->count();
        
        if ($activePurchases > 0) {
            return redirect()->route('admin.deliveries')
                            ->with('error', 'Cannot delete delivery with active purchases. Please complete or reassign purchases first.');
        }
    
        // Delete associated profile image
        if ($delivery->foto_profile) {
            Storage::disk('public')->delete($delivery->foto_profile);
        }
    
        // Set delivery_id to null for any remaining purchases
        $delivery->purchases()->update(['delivery_id' => null]);
    
        $delivery->delete();
    
        return redirect()->route('admin.deliveries')->with('success', 'Delivery deleted successfully');
    }
}