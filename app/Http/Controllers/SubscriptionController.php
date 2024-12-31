<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $subscriptions = Subscription::where('user_id', $user->id)->get();

        return view('subscriptions.index', [
            'title' => 'My Subscriptions',
            'subscriptions' => $subscriptions,
        ]);
    }

    public function pricing()
    {
        $user = Auth::user();
        $plans = Plan::all();
        $userSubscriptions = $user->subscriptions->pluck('plan_id'); // Ambil semua plan_id yang dimiliki pengguna
    
        foreach ($plans as $plan) {
            // Cek apakah pengguna sudah berlangganan plan ini
            $isSubscribed = $userSubscriptions->contains($plan->id);
    
            // Tentukan URL untuk tombol
            $plan->button_url = $isSubscribed
                ? route('home')
                : ($plan->name === 'Free Plan' ? route('home') : route('subscriptions.checkout', ['plan' => $plan->slug]));
    
            // Tentukan kelas tombol
            $plan->button_class = $plans->last()->id === $plan->id ? 'btn-primary' : 'btn-outline-primary';
        }
    
        return view('subscriptions.pricing', [
            'title' => 'Pricing',
            'plans' => $plans,
        ]);
    }    

    public function checkout(Plan $plan) {
        $paymentMethods = PaymentMethod::all();

        return view('subscriptions.checkout', [
            'title' => 'Checkout',
            'plan' => $plan,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $plan = json_decode($request->plan, true); // true untuk array, false untuk objek

        $billing_cycle = $plan['billing_cycle'];
        if( $billing_cycle == 'daily') {
            $endDate = now()->addDays(1);
        } else if ( $billing_cycle == 'weekly' ) {
            $endDate = now()->addWeeks(1);
        } elseif ( $billing_cycle == 'monthly' ) {
            $endDate = now()->addMonths(1);
        } elseif ( $billing_cycle == 'yearly' ) {
            $endDate = now()->addYears(1);
        }

        $subscription = Subscription::create([
            'user_id' => Auth::user()->id,
            'plan_id' => $plan['id'],
            'status' => 'pending',
            'start_date' => now(),
            'end_date' => $endDate,
            'auto_renew' => true
        ]);

        $subsPayment = SubscriptionPayment::create([
            'subscription_id' => $subscription['id'],
            'payment_method_id' => $request->payment_method_id,
            'amount' => $plan['price'],
            'payment_status' => 'Pending'
        ]);

        $this->processPayment($subsPayment);

        return redirect()->route('subscriptions.snap', $subscription->id);
    }

    public function cancelPayment(Subscription $subscription)
    {
        // Set Failed Message
        session()->flash('failed', __('subscriptions.payment_cancelled'));

        // Update transaction status
        $subscription->status = 'pending';
        $subscription->save();

        return redirect()->route('subscriptions.index');
    }

    private function processPayment(SubscriptionPayment $subsPayment)
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
                'order_id' => rand(),
                'gross_amount' => $subsPayment['amount'],
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email
            ),
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $subsPayment->snap_token = $snapToken;

        $subsPayment->save();
    }

    public function payment(Subscription $subscription) {
        // Fetch Plan
        $plan = Plan::where('id', $subscription->plan_id)->first();
        
        // Fetch Subscription Payment
        $subsPayment = SubscriptionPayment::where('subscription_id', $subscription->id)->first();

        return view('subscriptions.snap', [
            'title' => 'Payment',
            'plan' => $plan,
            'subscription' => $subscription,
            'subsPayment' => $subsPayment,
        ]);
    }

    public function success(Subscription $subscription) {
        // Update Subscription Status as Active
        $subscription->status = 'active';
        $subscription->save();

        // Get Subscription Payment Model
        $subsPaymentModel = SubscriptionPayment::where('subscription_id', $subscription->id)->first();

        if ($subsPaymentModel) {
            // Update payment status and time
            $subsPaymentModel->update([
                'payment_status' => 'Paid',
                'payment_time' => now(),
            ]);
        } else {
            return redirect()->back()->withErrors(['error' => 'Payment record not found.']);
        }

        // Fetch Plan
        $plan = Plan::where('id', $subscription->plan_id)->first();

        return view('subscriptions.success', [
            'title' => 'Success',
            'subs' => $subscription,
            'subs_payment' => $subsPaymentModel,
            'plan' => $plan,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
