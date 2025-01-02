<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TransactionPaymentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil parameter 'transaction' dari route
        $transaction = $request->route('transaction');

        // Ambil data user
        $user = Auth::user();
        
        if ($transaction->buyer->id !== $user->id) {
            return redirect()->route('home');
        }
    
        // Lakukan pengecekan pada Payment terkait
        $payment = $transaction->payment;
    
        if ($payment->payment_status === 'Paid') {
            return redirect()->route('transactions.payment-success', $transaction->order_number);
        }
    
        return $next($request);
    }
}
