<?php

namespace App\Http\Middleware;

use App\Models\Payment;
use App\Models\Transaction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PaymentMiddleware
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
    
        // Lakukan pengecekan pada Payment terkait
        $payment = $transaction->payment;
    
        if ($payment->payment_status === 'Pending') {
            return redirect()->route('payments.snap', $transaction->order_number);
        }
    
        if ($payment->payment_status === 'Paid') {
            return redirect()->route('payments.payment-success', $transaction->order_number);
        }
    
        return $next($request);
    }
}
