<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class AdminOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.options.index', [
            'options' => Option::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.options.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:options'
        ]);

        Option::create($validatedData);

        return redirect()->route('admin.options.index')->with('success', 'New option has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Option $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Option $option)
    {
        return view('dashboard.options.edit', [
            'option' => $option
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Option $option)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        if( $request->slug != $option->slug )
        {
            $rules['slug'] = 'required|unique:options';
        }

        $validatedData = $request->validate($rules);

        Option::where('id', $option->id)->update($validatedData);

        return redirect()->route('admin.options.index')->with('success', 'Option has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option)
    {
        Option::destroy($option->id);

        return redirect()->route('admin.options.index')>with('success', 'Option has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Option::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
