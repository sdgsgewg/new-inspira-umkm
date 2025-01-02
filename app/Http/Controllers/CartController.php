<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CartController extends Controller
{
    // Display Cart Page
    public function index()
    {
        $cart = Cart::with('designs')->where('user_id', Auth::id())->first();
        
        $carts = Cart::with('designs')->where('user_id', Auth::id())->get();
        
        $cartItems = [];
        foreach ($carts as $cart) {
            foreach ($cart->designs as $design) {
                $sellerId = $design->seller->id;
                $sellerName = $design->seller->name;
                $sellerUsername = $design->seller->username;
    
                if (!isset($cartItems[$sellerId])) {
                    $cartItems[$sellerId] = [
                        'seller_name' => $sellerName,
                        'seller_username' => $sellerUsername,
                        'items' => []
                    ];
                }
    
                $cartItems[$sellerId]['items'][] = $design;
            }
        }

        return view('cart.cart', [
            'title' => __('cart.my_cart'),
            'cart' => $cart,
            'cartItems' => $cartItems
        ]);
    }

    public function create()
    {
        //
    }

    // Menambah design ke dalam cart
    public function store(Request $request)
    {
        $design = Design::where('id', $request['designId'])->first();
        $quantity = intval($request->quantity);

        // Check if the design is retrieved correctly
        if (!$design) {
            return redirect()->back()->with('error', 'Design not found.');
        }

        $user = Auth::user();
        
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $cartDesign = $cart->designs()->where('design_id', $design->id)->first();

        // Jika sudah ada cart untuk design terkait
        if ($cartDesign) {
            $cart->designs()->updateExistingPivot($design->id, [
                'quantity' => $cartDesign->pivot->quantity + 1,
                'isChecked' => true
            ]);
        } else {
            // Jika belum ada cart untuk design terkait
            $cart->designs()->attach($design->id, [
                'quantity' => $quantity,
                'isChecked' => true
            ]);
        }

        return redirect()->back()->with('success', __('cart.design_added_to_cart'));
    }

    public function show(Cart $cart)
    {
        //
    }

    public function edit(Cart $cart)
    {
        //
    }

    public function update(Request $request, Cart $cart)
    {
        $designId = $request->input('design_id');
        $design = Design::find($designId);

        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:0|max:' . $design["stock"]
        ]);

        $cart = Cart::find($cart->id);
    
        if ($cart) {
            $cart->designs()->updateExistingPivot($designId, ['quantity' => $validatedData['quantity']]);
            return redirect()->back();
        }
    }

    // Buat update checkbox di cart page
    public function updateIsChecked(Request $request)
    {
        $request->validate([
            'design_id' => 'required|integer|exists:cart_designs,design_id',
            'is_checked' => 'required|boolean',
        ]);

        // Find the cart item by book ID and update its isChecked status
        $cartItem = Cart::where('user_id', Auth::id())
            ->whereHas('designs', function ($query) use ($request) {
                $query->where('design_id', $request->design_id);
            })
            ->first();

        if ($cartItem) {
            $cartItem->designs()->updateExistingPivot($request->design_id, ['isChecked' => $request->is_checked]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    // Buat update quantity per design item
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'design_id' => 'required|integer|exists:cart_designs,design_id',
            'quantity' => 'required|integer|min:0'
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->whereHas('designs', function ($query) use ($request) {
                $query->where('design_id', $request->design_id);
            })
            ->first();

        if ($cartItem) {
            $cartItem->designs()->updateExistingPivot($request->design_id, ['quantity' => $request->quantity]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    // Buat hapus design dari cart
    public function destroy(Request $request, Cart $cart)
    {
        $designId = $request->input('design_id');
        $cart->designs()->detach($designId);
        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
