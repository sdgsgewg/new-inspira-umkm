<?php

namespace App\Http\Controllers;

use App\Models\Product;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.products.index', [
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:products|max:255',
            'slug' => 'required|unique:products',
            'image' => 'image|file|max:1024'
        ]);

        // if($request->file('image')) {
        //     $validatedData['image'] = $request->file('image')->store('product-images');
        // }

        if ($request->file('image')) {
            try {
                // Upload ke Cloudinary
                $upload = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'product-images' // Folder di Cloudinary
                ]);
        
                // Menyimpan URL file di database
                $validatedData['image'] = $upload->getSecurePath();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
            }
        }

        Product::create($validatedData);

        return redirect()->route('admin.products.index')->with('success', __('dashboard.product_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('dashboard.products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required|max:255',
            'image' => 'image|file|max:1024'
        ];
    
        if ($request->slug != $product->slug) {
            $rules['slug'] = 'required|unique:products';
        }
    
        $validatedData = $request->validate($rules);
    
        if ($request->file('image')) {
            // Hapus gambar lama dari Cloudinary jika ada
            if ($product->image) {
                try {
                    // Ekstrak public ID dari URL gambar lama
                    $publicId = basename($product->image, '.' . pathinfo($product->image, PATHINFO_EXTENSION));
                    Cloudinary::destroy("product-images/{$publicId}");
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Failed to delete old image: ' . $e->getMessage());
                }
            }
    
            // Upload gambar baru ke Cloudinary
            try {
                $upload = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'product-images'
                ]);
    
                $validatedData['image'] = $upload->getSecurePath();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
            }
        }
    
        // Update data produk di database
        Product::where('id', $product->id)->update($validatedData);
    
        return redirect()->route('admin.products.index')->with('success', __('dashboard.product_updated'));
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            try {
                // Ekstrak public ID dari URL gambar
                $publicId = basename($product->image, '.' . pathinfo($product->image, PATHINFO_EXTENSION));
                Cloudinary::destroy("product-images/{$publicId}");
            } catch (\Exception $e) {
                return redirect()->route('admin.products.index')->with('error', 'Failed to delete image: ' . $e->getMessage());
            }
        }
    
        // Hapus produk dari database
        Product::destroy($product->id);
    
        return redirect()->route('admin.products.index')->with('success', __('dashboard.product_deleted'));
    }    

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
