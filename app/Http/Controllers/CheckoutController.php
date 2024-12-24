<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Design;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart = Cart::with('designs')->where('user_id', Auth::id())->first();
        
        $carts = Cart::with('designs')->where('user_id', Auth::id())->get();

        $checkoutItems = [];

        foreach ($carts as $cart) {
            foreach ($cart->designs as $design) {
                if ($design->pivot->isChecked) {
                    $sellerId = $design->seller->id;
                    $sellerName = $design->seller->name;
                    $sellerUsername = $design->seller->username;
        
                    if (!isset($checkoutItems[$sellerId])) {
                        $checkoutItems[$sellerId] = [
                            'seller_name' => $sellerName,
                            'seller_username' => $sellerUsername,
                            'items' => []
                        ];
                    }
        
                    $checkoutItems[$sellerId]['items'][] = $design;
                }
            }
        }

        $productAmount = [];
        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            $amount = 0;
            foreach($sellerGroup['items'] as $item) {
                $amount += $item->pivot->quantity;
            }
            $productAmount[] = $amount;
        }

        $checkoutItemsPrice = [];
        $totalPrice = 0;
        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            $subtotalPrice = 0;
            foreach($sellerGroup['items'] as $item) {
                $subtotalPrice += ($item->price * $item->pivot->quantity);
            }
            $checkoutItemsPrice[] = $subtotalPrice;
            $totalPrice += $subtotalPrice;
        }

        $paymentMethods = PaymentMethod::all();
        $shippingMethods = ShippingMethod::all();

        session(['fromPage' => 'Cart']);

        return view('checkout.checkout', [
            'title' => 'Checkout',
            'buyer' => Auth::user(),
            // 'cart' => $cart,
            'checkoutItems' => $checkoutItems,
            'productAmount' => $productAmount,
            'checkoutItemsPrice' => $checkoutItemsPrice,
            'subTotalPrice' => $totalPrice,
            'paymentMethods' => $paymentMethods,
            'shippingMethods' => $shippingMethods,
        ]);
    }

    public function checkoutFromDesign(Request $request)
    {
        $design = Design::findOrFail($request->input('design_id'));
        $quantity = 1;

        $checkoutItems = [];

        if ($design) {
            $sellerId = $design->seller->id;
            $sellerName = $design->seller->name;
            $sellerUsername = $design->seller->username;

            if (!isset($checkoutItems[$sellerId])) {
                $checkoutItems[$sellerId] = [
                    'seller_name' => $sellerName,
                    'seller_username' => $sellerUsername,
                    'items' => []
                ];
            }

            $checkoutItems[$sellerId]['items'][] = $design;
        }

        $productAmount = [];
        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            $amount = 0;
            foreach($sellerGroup['items'] as $item) {
                $amount += $quantity;
            }
            $productAmount[] = $amount;
        }

        $checkoutItemsPrice = [];
        $totalPrice = 0;
        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            $subtotalPrice = 0;
            foreach($sellerGroup['items'] as $item) {
                $subtotalPrice += ($item->price * $quantity);
            }
            $checkoutItemsPrice[] = $subtotalPrice;
            $totalPrice += $subtotalPrice;
        }

        $paymentMethods = PaymentMethod::all();
        $shippingMethods = ShippingMethod::all();

        session(['fromPage' => 'DesignDetail']);

        return view('checkout.checkout', [
            'title' => 'Checkout',
            'buyer' => Auth::user(),
            'checkoutItems' => $checkoutItems,
            'quantity' => 1,
            'productAmount' => $productAmount,
            'checkoutItemsPrice' => $checkoutItemsPrice,
            'subTotalPrice' => $totalPrice,
            'paymentMethods' => $paymentMethods,
            'shippingMethods' => $shippingMethods,
        ]);
    }
}
