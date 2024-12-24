<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return view('dashboard.categories.index', [
            'products' => Product::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create', [
            'products' => Product::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'slug' => 'required|unique:categories',
            'product_id' => 'required'
            // 'image' => 'image|file|max:1024'
        ]);

        // if($request->file('image')) {
        //     $validatedData['image'] = $request->file('image')->store('category-images');
        // }

        Category::create($validatedData);

        session(['product_id' => $request->product_id]);
        session()->forget('product_id');

        return redirect()->route('admin.categories.index')->with('success', 'New category has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', [
            'category' => $category,
            'products' => Product::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|max:255',
            'product_id' => 'required'
            // 'image' => 'image|file|max:1024'
        ];

        if( $request->slug != $category->slug )
        {
            $rules['slug'] = 'required|unique:categories';
        }

        $validatedData = $request->validate($rules);

        // if($request->file('image')) {
        //     if($request->oldImage) {
        //         Storage::delete($request->oldImage);
        //     }
        //     $validatedData['image'] = $request->file('image')->store('category-images');
        // }

        Category::where('id', $category->id)->update($validatedData);

        session(['product_id' => $request->product_id]);
        session()->forget('product_id');

        return redirect('/dashboard/categories')->with('success', 'Category has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // if($category->image) {
        //     Storage::delete($category->image);
        // }
        Category::destroy($category->id);

        return redirect('/dashboard/categories')->with('success', 'Category has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}