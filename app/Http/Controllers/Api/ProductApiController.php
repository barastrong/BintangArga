<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Facades\Auth;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'sizes', 'ratings', 'user']);

        if ($request->has('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $perPage = $request->get('per_page', 10);
        $products = $query->paginate($perPage);

        return new ProductCollection($products);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'seller_id' => 'required|exists:sellers,id',
            'nama_barang' => 'required|string|max:255',
            'description' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sizes' => 'required|array',
            'sizes.*.size' => 'required|in:S,M,L,XL',
            'sizes.*.harga' => 'required|numeric|min:0',
            'sizes.*.stock' => 'required|integer|min:0',
            'sizes.*.gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
    
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
    
            foreach ($request->sizes as $index => $sizeData) {
                $sizeImage = $request->file("sizes.{$index}.gambar");
                $gambarSizePath = $sizeImage->store('sizes', 'public');
                
                Size::create([
                    'product_id' => $product->id,
                    'size' => $sizeData['size'],
                    'harga' => $sizeData['harga'],
                    'stock' => $sizeData['stock'],
                    'gambar_size' => $gambarSizePath,
                ]);
            }
    
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => new ProductResource($product->load('sizes'))
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollback();
            
            if(isset($gambarPath)) {
                Storage::disk('public')->delete($gambarPath);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating product',
                'error' => $e->getMessage() 
            ], 500);
        }
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::with(['category', 'sizes', 'ratings', 'user'])
                            ->find($id);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => new ProductResource($product)
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in show method: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving product',
                'error' => env('APP_DEBUG', false) ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $product = Product::findOrFail($id);
            
            if (Auth::check()) {
                $seller = Seller::where('user_id', Auth::id())->first();
                
                if (!$seller || $product->seller_id != $seller->id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You do not have permission to delete this product'
                    ], 403);
                }
            }
            
            foreach ($product->sizes as $size) {
                if ($size->gambar_size) {
                    Storage::disk('public')->delete($size->gambar_size);
                }
                $size->delete();
            }
            
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            
            $product->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => $id,
                'message' => 'Product deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}