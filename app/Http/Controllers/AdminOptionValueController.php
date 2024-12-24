<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Option;
use App\Models\OptionValue;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class AdminOptionValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedOption = session('option_id', null);
        session()->forget('option_id');

        return view('dashboard.option-values.index', [
            'options' => Option::all(),
            'optionValues' => OptionValue::all(),
            'selectedOptionId' => $selectedOption
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.option-values.create', [
            'options' => Option::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'value' => 'required|max:255',
            'slug' => 'required|unique:option_values',
            'option_id' => 'required',
            'category_id' => 'nullable'
        ]);

        OptionValue::create($validatedData);

        session(['option_id' => $request->option_id]);

        return redirect()->route('admin.option-values.index')
        ->with('success', 'New option value has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OptionValue $optionValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OptionValue $optionValue)
    {
        return view('dashboard.option-values.edit', [
            'optionValue' => $optionValue,
            'options' => Option::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OptionValue $optionValue)
    {
        $rules = [
            'value' => 'required|max:255',
            'option_id' => 'required',
            'category_id' => 'nullable'
        ];

        if( $request->slug != $optionValue->slug )
        {
            $rules['slug'] = 'required|unique:option_values';
        }

        $validatedData = $request->validate($rules);

        OptionValue::where('id', $optionValue->id)->update($validatedData);
        
        session(['option_id' => $request->option_id]);

        return redirect()->route('admin.option-values.index')
        ->with('success', 'Option value has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OptionValue $optionValue)
    {
        OptionValue::destroy($optionValue->id);

        return redirect()->route('admin.option-values.index')->with('success', 'Option value has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(OptionValue::class, 'slug', $request->value);
        return response()->json(['slug' => $slug]);
    }
}
