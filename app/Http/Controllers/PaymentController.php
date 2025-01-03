<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Promotion;
use App\Models\Shipping;
use App\Models\ShippingMethod;
use App\Models\Transaction;
use App\Models\TransactionDesign;
use App\Models\TransactionPromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function showPayment(Transaction $transaction)
    {
        $transactionId = $transaction->id;

        // Get Seller
        $seller = $transaction->seller;
        
        // Fetch All Designs from the transaction
        $designs = $transaction->designs;

        // Get Product Amount
        $productAmount = 0;
        foreach ($designs as $design) {
            $productAmount += $design['pivot']['quantity'];
        }

        // Get Subtotal for all products
        $subTotalPrice = 0;
        foreach ($designs as $design) {
            $subTotalPrice += $design->pivot->sub_total_price;
        }

        // Fetch Option Values for Each Design
        $optionValueResults = DB::table('transaction_designs as td')
        ->join('design_options as do', 'td.design_id', '=', 'do.design_id')
        ->join('designs as d', 'td.design_id', '=', 'd.id')
        ->join('products as p', 'd.product_id', '=', 'p.id')
        ->join('option_values as ov', 'do.option_value_id', '=', 'ov.id')
        ->join('options as o', 'ov.option_id', '=', 'o.id')
        ->where('td.transaction_id', $transactionId)
        ->groupBy('td.design_id', 'd.title', 'p.name', 'o.name', 'ov.value') // Tambahkan kolom non-agregat ke GROUP BY
        ->select(
            'td.design_id',
            // Design Name
            'd.title as design_title',
            // Product Name
            'p.name as product_name',
            // Option Name
            'o.name as option_name',
            // Option Value
            'ov.value as option_value'
        )
        ->get();

        // Get Transaction Notes
        $notes = $transaction['notes'];
        
        // Get Shipping Method
        $shippingMethod = $transaction->shipping->shippingMethod;
        
        // Fetch All Payment Methods
        $paymentMethods = PaymentMethod::all();

        // Fetch Shipping Fee
        $shippingFee = $shippingMethod['shipping_fee'];

        // Fetch Service Fee
        $serviceFee = $transaction['service_fee'];

        // Fetch Grand Total Price
        $grandTotalPrice = $transaction['grand_total_price'];
    
        return view('checkout.payment', [
            'title' => 'Payment',
            'transaction' => $transaction,
            'seller' => $seller,
            'designs' => $designs,
            'productAmount' => $productAmount,
            'optionValueResults' => $optionValueResults,
            'notes' => $notes,
            'shippingMethod' => $shippingMethod,
            'paymentMethods' => $paymentMethods,
            'subTotalPrice' => $subTotalPrice,
            'shippingFee' => $shippingFee,
            'serviceFee' => $serviceFee,
            'grandTotalPrice' => $grandTotalPrice,
        ]);
    }

    public function showPaymentPromo(Transaction $transaction)
    {
        $transactionId = $transaction->id;

        // Get Seller
        $seller = $transaction->seller;
        
        // Fetch All Promotions from the Transaction
        $promotions = $transaction->promotions;
        $quantity = 1;

        // Fetch All Designs from the Transaction
        $designs = $transaction->designs;

        // Get Product Amount
        $productAmount = 0;
        foreach ($designs as $design) {
            $productAmount += $design['pivot']['quantity'];
        }

        // Get Subtotal for all products
        $subTotalPrice = 0;
        foreach ($designs as $design) {
            $subTotalPrice += $design->pivot->sub_total_price;
        }

        // Fetch Option Values for Each Design
        $optionValueResults = DB::table('transaction_designs as td')
        ->join('design_options as do', 'td.design_id', '=', 'do.design_id')
        ->join('designs as d', 'td.design_id', '=', 'd.id')
        ->join('products as p', 'd.product_id', '=', 'p.id')
        ->join('option_values as ov', 'do.option_value_id', '=', 'ov.id')
        ->join('options as o', 'ov.option_id', '=', 'o.id')
        ->where('td.transaction_id', $transactionId)
        ->groupBy('td.design_id', 'd.title', 'p.name', 'o.name', 'ov.value') // Tambahkan kolom non-agregat ke GROUP BY
        ->select(
            'td.design_id',
            // Design Name
            'd.title as design_title',
            // Product Name
            'p.name as product_name',
            // Option Name
            'o.name as option_name',
            // Option Value
            'ov.value as option_value'
        )
        ->get();

        // Get Transaction Notes
        $notes = $transaction['notes'];

        // Get Shipping Method
        $shippingMethod = $transaction->shipping->shippingMethod;
        
        // Fetch All Payment Methods
        $paymentMethods = PaymentMethod::all();

        // Fetch Shipping Fee
        $shippingFee = $shippingMethod['shipping_fee'];

        // Fetch Service Fee
        $serviceFee = $transaction['service_fee'];

        // Fetch Grand Total Price
        $grandTotalPrice = $transaction['grand_total_price'];

        return view('checkout.payment-promo', [
            'title' => 'Payment',
            'transaction' => $transaction,
            'seller' => $seller,
            'promotions' => $promotions,
            'quantity' => $quantity,
            'productAmount' => $productAmount,
            'optionValueResults' => $optionValueResults,
            'notes' => $notes,
            'shippingMethod' => $shippingMethod,
            'paymentMethods' => $paymentMethods,
            'subTotalPrice' => $subTotalPrice,
            'shippingFee' => $shippingFee,
            'serviceFee' => $serviceFee,
            'grandTotalPrice' => $grandTotalPrice,
        ]);
    }
    
    public function showPaymentSnap(Transaction $transaction)
    {
        $designs = $transaction->designs;

        $promotions = $transaction->promotions;

        return view('payment.snap', [
            'title' => 'Payment',
            'transaction' => $transaction,
            'designs' => $designs,
            'promotions' => $promotions,
        ]);
    }

    public function showPaymentSuccess(Transaction $transaction)
    {
        // Update Transaction Status as Pending
        $transaction->update([
            'transaction_status' => "Pending",
        ]);
        $transaction->save();

        // Get Payment Model
        $paymentModel = $transaction->payment;

        if ($paymentModel) {
            // Update payment status and time
            $paymentModel->update([
                'payment_status' => 'Paid',
                'payment_time' => now(),
            ]);
        } else {
            return redirect()->back()->withErrors(['error' => 'Payment record not found.']);
        }

        // Hapus session yang menandai Snap Page telah diakses
        session()->forget("snap_accessed_{$transaction->id}");

        // Set session of selected status as Pending
        session(['selectedStatus' => $transaction->transaction_status]);

        return view('payment.success', [
            'title' => 'Payment Success',
            'transaction' => $transaction,
        ]);
    }

}
