<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Seller;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'sizes', 'ratings', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function create()
    {
        $categories = Category::all();

        $seller = Seller::where('user_id', Auth::id())->first();
        
        return view('products.create', compact('categories', 'seller'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_barang' => 'required|string|max:255',
            'description' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seller_id' => 'required|exists:sellers,id',
        ]);
    
        try {
            DB::beginTransaction();
            $gambarPath = $request->file('gambar')->store('products', 'public');

            $product = Product::create([
                'seller_id' => $request->seller_id,
                'category_id' => $request->category_id,
                'nama_barang' => $request->nama_barang,
                'description' => $request->description,
                'lokasi' => $request->lokasi,
                'alamat_lengkap' => $request->alamat_lengkap,
                'gambar' => $gambarPath,
            ]);

            $availableSizes = ['S', 'M', 'L', 'XL'];
            foreach ($availableSizes as $sizeName) {
                // Check if size is toggled
                if ($request->input("size_active.$sizeName") === 'on') {
                    // Validate size data
                    $sizeData = $request->validate([
                        "sizes.$sizeName.harga" => 'required|numeric|min:0',
                        "sizes.$sizeName.stock" => 'required|integer|min:0',
                        "sizes.$sizeName.gambar" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    ]);

                    $gambarSizePath = $request->file("sizes.$sizeName.gambar")->store('sizes', 'public');
                    
                    // Create size record
                    Size::create([
                        'product_id' => $product->id,
                        'size' => $sizeName,
                        'harga' => $request->input("sizes.$sizeName.harga"),
                        'stock' => $request->input("sizes.$sizeName.stock"),
                        'gambar_size' => $gambarSizePath,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            
            // Hapus gambar yang sudah diupload jika ada error
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
        $product = Product::with(['sizes', 'ratings', 'user'])->findOrFail($id);
        $averageRating = $product->ratings->avg('rating') ?? 0;
        
        return view('products.show', compact('product', 'averageRating'));
    }

    public function shop(Request $request)
    {
        // Query builder untuk products
        $query = Product::with(['sizes', 'ratings']);

        // Filter berdasarkan lokasi jika ada
        if ($request->has('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        // Search berdasarkan nama barang
        if ($request->has('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Ambil lokasi unik untuk dropdown
        $locations = Product::select('lokasi')->distinct()->get();

        // Pagination (12 items per page)
        $products = $query->paginate(12);

        return view('products.shop', compact('products', 'locations'));
    }

    public function edit($id)
{
    $product = Product::with('sizes')->findOrFail($id);
    
    // Check if the current user is the owner of the product
    $seller = Seller::where('user_id', Auth::id())->first();
    
    if (!$seller || $product->seller_id != $seller->id) {
        return redirect()->route('products.index')
            ->with('error', 'Anda tidak memiliki izin untuk mengedit produk ini');
    }
    
    $categories = Category::all();
    
    return view('products.edit', compact('product', 'categories', 'seller'));
}

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // Check if the current user is the owner of the product
        $seller = Seller::where('user_id', Auth::id())->first();
        
        if (!$seller || $product->seller_id != $seller->id) {
            return redirect()->route('products.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit produk ini');
        }
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_barang' => 'required|string|max:255',
            'description' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        try {
            DB::beginTransaction();
            $productData = [
                'category_id' => $request->category_id,
                'nama_barang' => $request->nama_barang,
                'description' => $request->description,
                'lokasi' => $request->lokasi,
                'alamat_lengkap' => $request->alamat_lengkap,
            ];
            
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama
                if ($product->gambar) {
                    Storage::disk('public')->delete($product->gambar);
                }
                
                $productData['gambar'] = $request->file('gambar')->store('products', 'public');
            }
            
            $product->update($productData);

            $availableSizes = ['S', 'M', 'L', 'XL'];
            foreach ($availableSizes as $sizeName) {
                // Check if size is toggled
                if ($request->input("size_active.$sizeName") === 'on') {
                    $size = Size::where('product_id', $product->id)
                        ->where('size', $sizeName)
                        ->first();
                    
                    $sizeData = [
                        'product_id' => $product->id,
                        'size' => $sizeName,
                        'harga' => $request->input("sizes.$sizeName.harga"),
                        'stock' => $request->input("sizes.$sizeName.stock"),
                    ];
                    
                    if ($request->hasFile("sizes.$sizeName.gambar")) {
                        // Hapus gambar lama jika ada
                        if ($size && $size->gambar_size) {
                            Storage::disk('public')->delete($size->gambar_size);
                        }
                        
                        $sizeData['gambar_size'] = $request->file("sizes.$sizeName.gambar")->store('sizes', 'public');
                    }
                    
                    // Update atau buat ukuran
                    if ($size) {
                        $size->update($sizeData);
                    } else {
                        if (!isset($sizeData['gambar_size']) && $request->hasFile("sizes.$sizeName.gambar")) {
                            $sizeData['gambar_size'] = $request->file("sizes.$sizeName.gambar")->store('sizes', 'public');
                        }
                        
                        Size::create($sizeData);
                    }
                } else {
                    // Hapus ukuran jika tidak diaktifkan
                    $size = Size::where('product_id', $product->id)
                        ->where('size', $sizeName)
                        ->first();
                    
                    if ($size) {
                        // Hapus gambar ukuran
                        if ($size->gambar_size) {
                            Storage::disk('public')->delete($size->gambar_size);
                        }
                        
                        // Hapus ukuran
                        $size->delete();
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->route('products.show', $product->id)
                ->with('success', 'Produk berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function destroy($id)
{
    $product = Product::findOrFail($id);
    
    // Check if the current user is the owner of the product
    $seller = Seller::where('user_id', Auth::id())->first();
    
    if (!$seller || $product->seller_id != $seller->id) {
        return redirect()->route('products.index')
            ->with('error', 'Anda tidak memiliki izin untuk menghapus produk ini');
    }
    
    try {
        DB::beginTransaction();
        
        // Hapus semua ukuran produk dan gambarnya
        foreach ($product->sizes as $size) {
            if ($size->gambar_size) {
                Storage::disk('public')->delete($size->gambar_size);
            }
            $size->delete();
        }
        
        // Hapus gambar produk
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }
        
        // Hapus produk
        $product->delete();
        
        DB::commit();
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    } catch (\Exception $e) {
        DB::rollback();
        
        return back()
            ->with('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
    }
}
public function category($categoryId)
{
    // Find the category
    $category = Category::findOrFail($categoryId);

    // Get products for this specific category
    $products = Product::with(['sizes', 'ratings'])
        ->where('category_id', $categoryId)
        ->paginate(12);

    // Get all categories for potential navigation
    $categories = Category::all();

    return view('products.category', compact('category', 'products', 'categories'));
}
}
