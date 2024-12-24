<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use App\Models\Transaction;
use App\Models\TransactionDesign;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $request->validate([
            'option_value_id.*' => 'required',
            'notes' => 'nullable',
            'payment_method_id' => 'required',
            'shipping_method_id' => 'required'
        ]);
    
        // Fetch option values
        $optionValues = $request->input('option_value_id');
        $optionValueOutputs = [];
        
        foreach ($optionValues as $designId => $options) {
            $design = Design::find($designId);
    
            foreach ($options as $optionId => $optionValueId) {
                $option = Option::find($optionId);
                $optionValue = OptionValue::find($optionValueId);
    
                $optionValueOutputs[] = "{$design->product->name} {$option->name} ({$design->title}): {$optionValue->value}";
            }
        }
    
        // Retrieve notes and payment/shipping methods
        $notes = $request->input('notes');
        $paymentMethodId = $request->input('payment_method_id');
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);
    
        $shippingMethodId = $request->input('shipping_method_id');
        $shippingMethod = ShippingMethod::findOrFail($shippingMethodId);
    
        // Determine source and fetch quantities or items
        $source = $request->input('source', session('fromPage'));
        $quantity = $source === 'DesignDetail' ? $request->input('quantity') : null;
    
        $checkoutItems = json_decode($request->input('checkoutItems'), true);
        $productAmount = json_decode($request->input('productAmount'), true);
        $checkoutItemsPrice = json_decode($request->input('checkoutItemsPrice'), true);
        $subTotalPrice = $request->input('subTotalPrice');
    
        return view('checkout.payment', [
            'title' => 'Payment',
            'optionValues' => $optionValues,
            'optionValueOutputs' => $optionValueOutputs,
            'notes' => $notes,
            'paymentMethod' => $paymentMethod,
            'shippingMethod' => $shippingMethod,
            'checkoutItems' => $checkoutItems,
            'productAmount' => $productAmount,
            'checkoutItemsPrice' => $checkoutItemsPrice,
            'subTotalPrice' => $subTotalPrice,
            'quantity' => $quantity,
            'source' => $source,
        ]);
    }
    
    public function processPayment(Transaction $transaction)
    {
        $transaction_designs = TransactionDesign::where('transaction_id', $transaction->id)->get();

        return view('payment.snap', [
            'title' => 'Payment',
            'transaction' => $transaction,
            'transaction_designs' => $transaction_designs,
        ]);
    }

    public function handlePaymentSuccess(Transaction $transaction)
    {
        return view('payment.success',[
            'title' => 'Payment Success',
            'transaction' => $transaction,
        ]);
    }
}