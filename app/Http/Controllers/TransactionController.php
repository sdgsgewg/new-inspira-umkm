<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Design;
use App\Models\DesignOption;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\TransactionDesign;
use App\Models\TransactionPromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->is_admin) {
            return redirect()->route('transactions.orderRequest');
        }

        $transactions = Transaction::with('seller', 'designs')
            ->where('buyer_id', Auth::id())
            ->latest()
            ->get()
            ->map(function ($transaction) {
                $transaction->nextStatuses = $transaction->getNextStatuses();
                return $transaction;
            });
    
        $status = Transaction::select('transaction_status')->distinct()->pluck('transaction_status')->toArray();
    
        $allStatus = Transaction::STATUSES;
    
        // Calculate transaction count per status
        $numTransactionByStatus = [];
        foreach ($allStatus as $status) {
            $numTransactionByStatus[$status] = $transactions->where('transaction_status', $status)->count();
        }
    
        $selectedStatus = session('selectedStatus', 'Completed');
        session()->forget('selectedStatus');
    
        return view('transaction.index', [
            'title' => 'My Orders',
            'transactions' => $transactions,
            'allStatus' => $allStatus,
            'status' => $status,
            'selectedStatus' => $selectedStatus,
            'numTransactionByStatus' => $numTransactionByStatus
        ]);
    }

    public function orderRequest()
    {
        if(!Auth::user()->is_admin) {
            return redirect()->route('transactions.index');
        }

        $transactions = Transaction::with('buyer', 'designs')
            ->where('seller_id', Auth::id())
            ->latest()
            ->get()
            ->map(function ($transaction) {
                $transaction->nextStatuses = $transaction->getNextStatuses();
                return $transaction;
            });

        $allStatus = Transaction::STATUSES;

        // Calculate transaction count per status
        $numTransactionByStatus = [];
        foreach ($allStatus as $status) {
            $numTransactionByStatus[$status] = $transactions->where('transaction_status', $status)->count();
        }

        $selectedStatus = session('selectedStatus', 'Pending');
        session()->forget('selectedStatus');

        return view('transaction.orderRequest', [
            'title' => 'Order Request',
            'transactions' => $transactions,
            'allStatus' => $allStatus,
            'selectedStatus' => $selectedStatus,
            'numTransactionByStatus' => $numTransactionByStatus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function storeDesignOptions($optionValues)
    {
        // Masukkan data ke tabel 'design_options'
        foreach ($optionValues as $designId => $options) {
            foreach ($options as $optionId => $optionValueId) {
                $designOption = DesignOption::create([
                    'design_id' => $designId,
                    'option_value_id' => $optionValueId,
                ]);
                $designOption->save();
            }
        }
    }

    private function storeTransaction($sellerId, $subTotalPrice, $serviceFee, $totalPrice, $notes)
    {
        $transaction = Transaction::create([
            'buyer_id' => Auth::id(),
            'seller_id' => $sellerId,
            'total_price' => $subTotalPrice,
            'service_fee' => $serviceFee,
            'grand_total_price' => $totalPrice,
            'transaction_status' => 'Not Paid',
            'notes' => $notes
        ]);

        $transaction->order_number = 'TX-' . now()->format('Ymd') . '-' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT);
        $transaction->save();

        return $transaction;
    }

    private function storeTransactionDesign($transactionId, $designId, $quantity, $subTotalPrice) 
    {
        TransactionDesign::create([
            'transaction_id' => $transactionId,
            'design_id' => $designId,
            'quantity' => $quantity,
            'sub_total_price' => $subTotalPrice,
        ]);
    }

    private function storeTransactionPromotion($transactionId, $promotionId, $quantity, $subTotalPrice)
    {
        TransactionPromotion::create([
            'transaction_id' => $transactionId,
            'promotion_id' => $promotionId,
            'quantity' => $quantity,
            'sub_total_price' => $subTotalPrice,
        ]);
    }

    private function updateDesignStock($designId, $quantity)
    {
        $designModel = Design::find($designId);
        $designModel->stock -= $quantity;
        $designModel->save();
    }

    private function processTransactionPerSeller($sellerId, $sellerGroup, $request)
    {
        $transaction = $this->storeTransaction($sellerId, $request->subTotalPrice, $request->serviceFee, $request->grandTotalPrice, $request->notes);

        $designIds = [];

        foreach ($sellerGroup['items'] as $design) {
            $quantity = $request->source !== 'Cart' ? $request->quantity : $design['pivot']['quantity'];

            $this->updateDesignStock($design['id'], $quantity);

            $this->storeTransactionDesign($transaction->id, $design['id'], $quantity, $design['price'] * $quantity);

            $designIds[] = $design['id'];
        }

        return [$transaction, $designIds];
    }

    private function processCheckoutItems($checkoutItems, $request)
    {
        $allDesignIds = [];
        $transactions = [];

        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            [$transaction, $designIds] = $this->processTransactionPerSeller($sellerId, $sellerGroup, $request);
            $transactions[] = $transaction;
            $allDesignIds = array_merge($allDesignIds, $designIds);
        }

        return [$transactions, $allDesignIds];
    }

    private function storeShipping($transactionId, $shipping_method_id)
    {
        $shipping = Shipping::create([
            'transaction_id' => $transactionId,
            'shipping_method_id' => $shipping_method_id,
            'shipping_status' => 'Awaiting Pickup'
        ]);
        // Generate tracking number
        $shipping->tracking_number = $this->generateTrackingNumber($shipping->id, $shipping->shipping_method_id);
        $shipping->save();
    }
    
    private function generateTrackingNumber($shippingId, $shippingMethodId)
    {
        $prefix = strtoupper(substr(md5($shippingMethodId), 0, 4)); // Generate prefix dari shipping method
        $timestamp = now()->format('YmdHis'); // Format tanggal dan waktu
        $uniqueId = str_pad($shippingId, 6, '0', STR_PAD_LEFT); // ID shipping dengan leading zeros

        return "{$prefix}-{$timestamp}-{$uniqueId}";
    }

    private function clearCartItems($designIds)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cart->designs()->detach($designIds);
        }
    }

    // Store transaction data on these table:
    // - design_options
    // - transactions
    // - transaction_designs
    // - transaction_promotions
    // - shippings
    // Then, clear design from cart if source page from cart page
    // Flow:
    // Checkout Page -> store -> Payment Page
    public function store(Request $request)
    {
        $request->validate([
            'option_value_id.*.*' => 'required|exists:option_values,id',
        ]);
        $optionValues = $request->input('option_value_id');

        $this->storeDesignOptions($optionValues);
    
        $checkoutItems = json_decode($request->checkoutItems, true);
    
        [$transactions, $designIds] = $this->processCheckoutItems($checkoutItems, $request);
    
        if ($request->source === 'DesignSelection') {
            $this->storeTransactionPromotion($transactions[0]->id, $request->promotion_id, $request->quantity, $request->subTotalPrice);
        }

        $this->storeShipping($transactions[0]->id, $request->shipping_method_id);
    
        if ($request->source === 'Cart') {
            $this->clearCartItems($designIds);
        }
    
        if ($request->source === 'DesignSelection') {
            return redirect()->route('transactions.paymentPromo', ['transaction' => $transactions[0]->order_number]);
        }

        return redirect()->route('transactions.payment', ['transaction' => $transactions[0]->order_number]);
    }

    private function storePayment($transactionId, $payment_method_id, $totalPrice)
    {
        $payment = Payment::create([
            'transaction_id' => $transactionId,
            'payment_method_id' => $payment_method_id,
            'amount' => $totalPrice
        ]);
        $payment->save();
    }
    
    // Store transaction data on these table:
    // - payments
    // - shippings
    // Then, generate snap_token
    // Flow:
    // Payment Page -> store -> Payment Snap Page
    public function storeAdditionalData(Request $request, Transaction $transaction)
    {
        $this->storePayment($transaction->id, $request->payment_method_id, $transaction->grand_total_price);

        session(['selectedStatus' => 'Not Paid']);

        $this->processPayment($transaction);
    
        return redirect()->route('transactions.snap', ['transaction' => $transaction->order_number]);
    }

    public function cancelPayment(Transaction $transaction)
    {
        // Set Failed Message
        session()->flash('failed', __('order.payment_cancelled'));
    
        // Update transaction status
        $transaction->transaction_status = 'Not Paid';
        $transaction->save();
    
        // Reset session flag for Snap Page
        if(session()->has("snap_accessed_{$transaction->id}")) {
            session()->forget("snap_accessed_{$transaction->id}");
        }
    
        // Set session of selected status
        session(['selectedStatus' => $transaction->transaction_status]);
    
        return redirect()->route('transactions.index');
    }    

    private function processPayment(Transaction $transaction)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaction['order_number'],
                'gross_amount' => $transaction['grand_total_price'],
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email
            ),
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction->snap_token = $snapToken;

        $transaction->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // Fetch Seller
        $seller = $transaction->seller;

        // ID pengguna yang sedang login
        $userId = Auth::id();

        // Fetch Option Values for Each Design
        $designs = DB::table('transaction_designs as td')
        ->join('design_options as do', 'td.design_id', '=', 'do.design_id')
        ->join('designs as d', 'td.design_id', '=', 'd.id')
        ->join('products as p', 'd.product_id', '=', 'p.id')
        ->leftJoin('design_reviews as dr', function ($join) use ($userId) {
            $join->on('d.id', '=', 'dr.design_id')
                 ->where('dr.user_id', '=', $userId);
        })
        ->join('option_values as ov', 'do.option_value_id', '=', 'ov.id')
        ->join('options as o', 'ov.option_id', '=', 'o.id')
        ->where('td.transaction_id', $transaction->id)
        ->groupBy('d.id', 'd.image', 'd.title', 'p.name', 'td.quantity', 'd.price', 'dr.isRated', 'o.name', 'ov.value') // Tambahkan kolom non-agregat ke GROUP BY
        ->select(
            'd.id as id',
            // Design Image
            'd.image as image',
            // Design Name
            'd.title as title',
            // Product Name
            'p.name as product_name',
            // Design Quantity
            'td.quantity as quantity',
            // Design Price
            'd.price as price',
            // Is Rated
            'dr.isRated as user_rating',
            // Option Name
            'o.name as option_name',
            // Option Value
            'ov.value as option_value'
        )
        ->get();

        return view('transaction.detail', [
            'title' => 'Transaction Detail',
            'transaction' => $transaction,
            'seller' => $seller,
            'designs' => $designs,
            'isSeller' => $userId === $transaction->seller->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $newStatus = $request->choice;

        if($newStatus === "Delivered") {
            // Update shipping time dari transaksi
            $shippingModel = Shipping::where('transaction_id', $transaction->id)->first();

            if ($shippingModel) {
                $shippingModel->shipping_time = now();
                $shippingModel->save();
            }

        } else if ( in_array( $newStatus, ['Returned', 'Cancelled'] ) ) {
            // Get Payment Model
            $paymentModel = $transaction->payment;

            if ($paymentModel) {
                // Update payment status as Failed
                $paymentModel->update([
                    'payment_status' => 'Failed'
                ]);
            } else {
                return redirect()->back()->withErrors(['error' => 'Payment record not found.']);
            }

            // Reset design stock
            foreach( $transaction->designs as $design ){
                $designModel = Design::find($design->id);
                $designModel->stock += $design->pivot->quantity;
                $designModel->save();
            }
        } else if ($newStatus === "Completed") {
            if (!$transaction->isReceived) {
                $transaction->isReceived = true;
                $transaction->save();

                $shippingModel = Shipping::where('transaction_id', $transaction->id)->first();

                if ($shippingModel) {
                    $shippingModel->shipping_status = "Delivered";
                    $shippingModel->delivery_time = now();
                    $shippingModel->save();
                }                

                session(['selectedStatus' => 'Delivered']);

                return redirect()->back()->with('success', __('order.order_received'));
            } else {
                $transaction->completion_time = now();
                $transaction->save();
            }
        }

        session(['selectedStatus' => $newStatus]);

        if ($transaction->transitionTo($newStatus)) {
            return redirect()->back()->with('success', __('order.transaction_updated'));
        }

        return redirect()->back()->with('error', 'Invalid status transition.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
