<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('designs.categories', [
            'title' => 'Design Categories',
            'categories' => Category::all()
        ]);
    }
}
