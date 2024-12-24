<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Product;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function home() {
        return view('home', [
            'title' => 'Home',
            'products' => Product::all(),
            'designs' => Design::all()
        ]);
    }

    public function about() {
        return view('about', [
            'title' => 'InspiraUMKM'
        ]);
    }
}
