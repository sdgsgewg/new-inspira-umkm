<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionPaymentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil parameter 'subscription' dari route
        $subscription = $request->route('subscription');
    
        // Lakukan pengecekan pada Payment terkait
        $payment = $subscription->subscriptionPayment;
    
        if ($payment->payment_status === 'Paid') {
            return redirect()->route('subscriptions.payment-success', $subscription->id);
        }
    
        return $next($request);
    }
}
