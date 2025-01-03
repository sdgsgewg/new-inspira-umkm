<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Design;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Checkout from Cart Page
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
        $subTotalPrice = 0;
        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            $subtotalPrice = 0;
            foreach($sellerGroup['items'] as $item) {
                $subtotalPrice += ($item->price * $item->pivot->quantity);
            }
            $checkoutItemsPrice[] = $subtotalPrice;
            $subTotalPrice += $subtotalPrice;
        }

        // $paymentMethods = PaymentMethod::all();
        $shippingMethods = ShippingMethod::all();

        session(['fromPage' => 'Cart']);

        return view('checkout.checkout', [
            'title' => 'Checkout',
            'buyer' => Auth::user(),
            'checkoutItems' => $checkoutItems,
            'productAmount' => $productAmount,
            'checkoutItemsPrice' => $checkoutItemsPrice,
            'shippingMethods' => $shippingMethods,
            'subTotalPrice' => $subTotalPrice,
            'serviceFee' => 1000,
        ]);
    }

    // Checkout from Design Detail Page
    public function checkoutFromDesign(Request $request)
    {
        // Initialize checkoutItems as an empty array.
        $checkoutItems = [];
    
        $design = Design::findOrFail($request['designId']);
        $quantity = intval($request['quantity']);

        // Get seller details
        $sellerId = $design->seller->id;
        $sellerName = $design->seller->name;
        $sellerUsername = $design->seller->username;

        // Populate checkoutItems for the seller
        $checkoutItems[$sellerId] = [
            'seller_name' => $sellerName,
            'seller_username' => $sellerUsername,
            'items' => [$design]
        ];
    
        // Calculate product amounts and prices for each seller.
        $productAmount = [];
        $checkoutItemsPrice = [];
        $subTotalPrice = 0;
    
        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            $amount = 0;
            $subtotalPrice = 0;

            foreach ($sellerGroup['items'] as $item) {
                $amount += $quantity;
                $subtotalPrice += $item->price * $quantity;
            }
            
            $productAmount[] = $amount;
            $checkoutItemsPrice[] = $subtotalPrice;
            $subTotalPrice += $subtotalPrice;
        }
    
        // Fetch shipping methods
        $shippingMethods = ShippingMethod::all();
    
        // Store session data to keep track of where the request is coming from
        session(['fromPage' => 'DesignDetail']);
    
        // Return the checkout view with all the data
        return view('checkout.checkout', [
            'title' => 'Checkout',
            'buyer' => Auth::user(),
            'checkoutItems' => $checkoutItems,
            'productAmount' => $productAmount,
            'quantity' => $quantity,
            'checkoutItemsPrice' => $checkoutItemsPrice,
            'shippingMethods' => $shippingMethods,
            'subTotalPrice' => $subTotalPrice,
            'serviceFee' => 1000,
        ]);
    }

    // Checkout from Design Selection Page
    public function checkoutFromPromotion(Request $request)
    {
        // Initialize checkoutItems as an empty array.
        $checkoutItems = [];

        // Iterate over each product and its selected design.
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'product_') === 0 && $value) {
                // Get product id from key (e.g. product_1, product_2)
                $productId = str_replace('product_', '', $key);

                // Get product and its selected design
                $product = Product::findOrFail($productId);
                $design = Design::findOrFail($value);

                // Get seller details
                $sellerId = $design->seller->id;
                $sellerName = $design->seller->name;
                $sellerUsername = $design->seller->username;

                // Add product to checkoutItems for the corresponding seller
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

        // Get Promotion Data
        $promotion = Promotion::where('id', $request->promotion_id)->first();
        // Get Promotion Price
        $promotionPrice = $promotion->price;
        // Get Original Price
        $originalPrice = $promotion->originalPrice;

        // Calculate product amounts and prices for each seller.
        $productAmount = [];
        $checkoutItemsPrice = [];
        $subTotalPrice = 0;
        $quantity = 1;
    
        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            $amount = 0;
            $subtotalPrice = 0;
    
            foreach ($sellerGroup['items'] as $item) {
                $amount += $quantity;
                $subtotalPrice += $item->price * $quantity;
            }

            $productAmount[] = $amount;
            $checkoutItemsPrice[] = $subtotalPrice;
            $subTotalPrice += $subtotalPrice;
        }
    
        // Fetch shipping methods
        $shippingMethods = ShippingMethod::all();
    
        // Store session data to keep track of where the request is coming from
        session(['fromPage' => 'DesignSelection']);
    
        // Return the checkout view with all the data
        return view('checkout.checkout-promo', [
            'title' => 'Checkout',
            'buyer' => Auth::user(),
            'checkoutItems' => $checkoutItems,
            'productAmount' => $productAmount,
            'quantity' => $quantity,
            'checkoutItemsPrice' => $checkoutItemsPrice,
            'promotion' => $promotion,
            'promotionPrice' => $promotionPrice,
            'originalPrice' => $originalPrice,
            'shippingMethods' => $shippingMethods,
            'subTotalPrice' => $subTotalPrice,
            'serviceFee' => 1000,
        ]);
    }

}
