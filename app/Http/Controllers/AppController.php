<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function home()
    {
        $userSubs = Subscription::where('user_id', Auth::id())->pluck('plan_id'); // Hanya ambil plan_id
        $promotions = Promotion::with('plans')->paginate(3);
    
        foreach ($promotions as $promo) {
            // Tambahkan properti akses pada setiap promo
            $promo->is_subscribed = $promo->plans->pluck('id')->intersect($userSubs)->isNotEmpty();
        }
    
        return view('home', [
            'title' => 'Home',
            'products' => Product::all(),
            'designs' => Design::all(),
            'promotions' => $promotions,
        ]);
    }    

    public function about() {
        return view('about', [
            'title' => 'InspiraUMKM'
        ]);
    }
}
