<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Product;
use App\Models\Category;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;

class DashboardDesignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.designs.index', [
            'designs' => Design::where('seller_id', Auth::user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.designs.create', [
            'products' => Product::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:designs',
            'product_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'image|file|max:1024',
            'description' => 'required'
        ]);

        // if($request->file('image')) {
        //     $validatedData['image'] = $request->file('image')->store('design-images');
        // }

        if ($request->file('image')) {
            try {
                // Upload ke Cloudinary
                $upload = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'design-images' // Folder di Cloudinary
                ]);
        
                // Menyimpan URL file di database
                $validatedData['image'] = $upload->getSecurePath();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
            }
        }

        $validatedData['seller_id'] = Auth::user()->id;

        Design::create($validatedData);

        return redirect()->route('admin.designs.index')->with('success', __('dashboard.design_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Design $design)
    {
        $avgDesignRating = DB::table('design_reviews')
        ->where('design_id', $design->id)
        ->avg('rating');

        $soldQuantity = DB::table('transaction_designs')
        ->where('design_id', $design->id)
        ->sum('quantity');

        return view('dashboard.designs.show', [
            'design' => $design,
            'avgDesignRating' => $avgDesignRating,
            'soldQuantity' => $soldQuantity,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Design $design)
    {
        $designCategory = $design->category->pluck('id')->toArray();

        return view('dashboard.designs.edit', [
            'design' => $design,
            'products' => Product::all(),
            'designCategory' => $designCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Design $design)
    {
        $rules = [
            'title' => 'required|max:255',
            'product_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'image|file|max:1024',
            'description' => 'required'
        ];

        if( $request->slug != $design->slug )
        {
            $rules['slug'] = 'required|unique:designs';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('design-images');
        }

        $validatedData['seller_id'] = Auth::user()->id;

        Design::where('id', $design->id)->update($validatedData);

        return redirect()->route('admin.designs.index')->with('success', __('dashboard.design_updated'));
    }

    public function getCategoriesByProduct($productId)
    {
        $categories = Category::where('product_id', $productId)->get();
        return response()->json($categories);
    }

    public function destroy(Design $design)
    {
        if($design->image) {
            Storage::delete($design->image);
        }
        Design::destroy($design->id);

        return redirect()->route('admin.designs.index')->with('success', __('dashboard.design_deleted'));
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Design::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
