<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'sizes', 'ratings'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
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
        ]);

        try {
            DB::beginTransaction();

            // Upload gambar produk
            $gambarPath = $request->file('gambar')->store('products', 'public');

            // Simpan produk
            $product = Product::create([
                'category_id' => $request->category_id,
                'nama_barang' => $request->nama_barang,
                'description' => $request->description,
                'lokasi' => $request->lokasi,
                'alamat_lengkap' => $request->alamat_lengkap,
                'gambar' => $gambarPath,
            ]);

            // Simpan ukuran dan harga
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

                    // Upload gambar size
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
        $product = Product::with(['sizes', 'ratings'])->findOrFail($id);
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
}