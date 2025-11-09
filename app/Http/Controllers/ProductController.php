<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Purchase;
use App\Models\Seller;
use App\Models\Size;
use App\Models\Province;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::with(['category', 'sizes', 'ratings', 'user', 'purchases', 'province', 'city'])
            ->select('products.*')
            ->leftJoin(DB::raw('(SELECT product_id, AVG(rating) as avg_rating FROM ratings GROUP BY product_id) as avg_ratings'), 
                                            'products.id', '=', 'avg_ratings.product_id')
            ->where('avg_ratings.avg_rating', '>=', 4.0)
            ->orderBy('avg_ratings.avg_rating', 'desc')
            ->take(5)
            ->get();
        
        foreach ($products as $product) {
            $product->purchase_count = Purchase::where('product_id', $product->id)
                ->whereIn('status', ['completed', 'selesai'])
                ->count();
        }

        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function create()
    {
        $categories = Category::all();
        $provinces = Province::orderBy('name')->get();
        $seller = Seller::where('user_id', Auth::id())->first();
        
        return view('products.create', compact('categories', 'provinces', 'seller'));
    }

    /**
     * [REVISI TOTAL] Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // 1. Definisikan aturan dasar
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'nama_barang' => 'required|string|max:255',
            'description' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'alamat_lengkap' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seller_id' => 'required|exists:sellers,id',
            'size_active' => 'required|array|min:1', // Pastikan minimal 1 ukuran aktif
        ];

        // 2. Bangun aturan untuk setiap ukuran yang aktif secara dinamis
        if ($request->has('size_active')) {
            foreach ($request->input('size_active') as $sizeName => $value) {
                $rules["sizes.$sizeName.harga"] = 'required|numeric|min:0';
                $rules["sizes.$sizeName.stock"] = 'required|integer|min:0';
                $rules["sizes.$sizeName.gambar"] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            }
        }

        // 3. Definisikan pesan error custom
        $messages = [
            'size_active.required' => 'Mohon pilih dan aktifkan minimal satu ukuran.',
            'sizes.*.harga.required' => 'Harga untuk ukuran yang dipilih wajib diisi.',
            'sizes.*.stock.required' => 'Stok untuk ukuran yang dipilih wajib diisi.',
            'sizes.*.gambar.required' => 'Gambar untuk ukuran yang dipilih wajib diisi.',
        ];

        // 4. Jalankan validasi HANYA SATU KALI
        $validatedData = $request->validate($rules, $messages);
    
        try {
            DB::beginTransaction();
            $gambarPath = $request->file('gambar')->store('products', 'public');

            $product = Product::create([
                'seller_id' => $validatedData['seller_id'],
                'category_id' => $validatedData['category_id'],
                'nama_barang' => $validatedData['nama_barang'],
                'description' => $validatedData['description'],
                'province_id' => $validatedData['province_id'],
                'city_id' => $validatedData['city_id'],
                'alamat_lengkap' => $validatedData['alamat_lengkap'],
                'gambar' => $gambarPath,
            ]);

            foreach ($request->input('size_active') as $sizeName => $value) {
                $gambarSizePath = $request->file("sizes.$sizeName.gambar")->store('sizes', 'public');
                
                Size::create([
                    'product_id' => $product->id,
                    'size' => $sizeName,
                    'harga' => $request->input("sizes.$sizeName.harga"),
                    'stock' => $request->input("sizes.$sizeName.stock"),
                    'gambar_size' => $gambarSizePath,
                ]);
            }

            DB::commit();
            
            // Redirect yang benar
            return redirect()->route('seller.products')
                ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            if(isset($gambarPath)) {
                Storage::disk('public')->delete($gambarPath);
            }
            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $product = Product::with(['sizes', 'ratings', 'user', 'province', 'city'])->findOrFail($id);
        $averageRating = $product->ratings->avg('rating') ?? 0;
        
        return view('products.show', compact('product', 'averageRating'));
    }

    public function shop(Request $request)
    {
        $query = Product::with(['sizes', 'ratings', 'province', 'city']);

        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $provinces = Province::orderBy('name')->get();
        $cities = collect();
        if ($request->filled('province_id')) {
            $cities = City::where('province_id', $request->province_id)->orderBy('name')->get();
        }
        
        $products = $query->paginate(12);
        
        foreach ($products as $product) {
            $product->purchase_count = Purchase::where('product_id', $product->id)
                ->whereIn('status', ['completed', 'selesai'])
                ->count();
        }

        return view('products.shop', compact('products', 'provinces', 'cities'));
    }

    public function edit($id)
    {
        $product = Product::with(['sizes', 'province', 'city'])->findOrFail($id);
        $seller = Seller::where('user_id', Auth::id())->first();
        
        if (!$seller || $product->seller_id != $seller->id) {
            return redirect()->route('products.index')->with('error', 'Anda tidak memiliki izin untuk mengedit produk ini');
        }
        
        $categories = Category::all();
        $provinces = Province::orderBy('name')->get();
        $cities = City::where('province_id', $product->province_id)->orderBy('name')->get();
        
        return view('products.edit', compact('product', 'categories', 'provinces', 'cities', 'seller'));
    }

    /**
     * [REVISI TOTAL] Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $seller = Seller::where('user_id', Auth::id())->first();
        
        if (!$seller || $product->seller_id != $seller->id) {
            return redirect()->route('products.index')->with('error', 'Anda tidak memiliki izin untuk mengedit produk ini');
        }
        
        // 1. Definisikan aturan dasar
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'nama_barang' => 'required|string|max:255',
            'description' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'alamat_lengkap' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'size_active' => 'required|array|min:1',
        ];

        // 2. Bangun aturan untuk setiap ukuran yang aktif secara dinamis
        if ($request->has('size_active')) {
            foreach ($request->input('size_active') as $sizeName => $value) {
                $rules["sizes.$sizeName.harga"] = 'required|numeric|min:0';
                $rules["sizes.$sizeName.stock"] = 'required|integer|min:0';
                $rules["sizes.$sizeName.gambar"] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
            }
        }

        // 3. Definisikan pesan error custom
        $messages = [
            'size_active.required' => 'Mohon pilih dan aktifkan minimal satu ukuran.',
            'sizes.*.harga.required' => 'Harga untuk ukuran yang aktif wajib diisi.',
            'sizes.*.stock.required' => 'Stok untuk ukuran yang aktif wajib diisi.',
        ];

        // 4. Jalankan validasi HANYA SATU KALI
        $request->validate($rules, $messages);
        
        try {
            DB::beginTransaction();
            $productData = $request->only(['category_id', 'nama_barang', 'description', 'province_id', 'city_id', 'alamat_lengkap']);
            
            if ($request->hasFile('gambar')) {
                if ($product->gambar) Storage::disk('public')->delete($product->gambar);
                $productData['gambar'] = $request->file('gambar')->store('products', 'public');
            }
            
            $product->update($productData);

            $availableSizes = ['S', 'M', 'L', 'XL'];
            foreach ($availableSizes as $sizeName) {
                $size = Size::where('product_id', $product->id)->where('size', $sizeName)->first();
                
                if ($request->input("size_active.$sizeName")) {
                    $sizeData = [
                        'harga' => $request->input("sizes.$sizeName.harga"),
                        'stock' => $request->input("sizes.$sizeName.stock"),
                    ];
                    
                    if ($request->hasFile("sizes.$sizeName.gambar")) {
                        if ($size && $size->gambar_size) Storage::disk('public')->delete($size->gambar_size);
                        $sizeData['gambar_size'] = $request->file("sizes.$sizeName.gambar")->store('sizes', 'public');
                    }
                    
                    Size::updateOrCreate(
                        ['product_id' => $product->id, 'size' => $sizeName],
                        $sizeData
                    );
                } else {
                    if ($size) {
                        if ($size->gambar_size) Storage::disk('public')->delete($size->gambar_size);
                        $size->delete();
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->route('seller.products')->with('success', 'Produk berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $seller = Seller::where('user_id', Auth::id())->first();
        
        if (!$seller || $product->seller_id != $seller->id) {
            return redirect()->route('products.index')->with('error', 'Anda tidak memiliki izin untuk menghapus produk ini');
        }
        
        try {
            DB::beginTransaction();
            
            foreach ($product->sizes as $size) {
                if ($size->gambar_size) Storage::disk('public')->delete($size->gambar_size);
                $size->delete();
            }
            
            if ($product->gambar) Storage::disk('public')->delete($product->gambar);
            $product->delete();
            
            DB::commit();
            
            return redirect()->route('seller.products')->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function category($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $products = Product::with(['sizes', 'ratings', 'province', 'city'])
            ->where('category_id', $categoryId)
            ->paginate(12);

        foreach ($products as $product) {
            $product->purchase_count = Purchase::where('product_id', $product->id)
                ->whereIn('status', ['completed', 'selesai'])
                ->count();
        }

        $categories = Category::all();
        return view('products.category', compact('category', 'products', 'categories'));
    }
}