<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PaymentSnapPageMiddleware
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

        // Jika tabel 'paymments' dari transaksi belum ada, maka redirect ke payment summary page
        if (!$payment) {
            return redirect()->route('transactions.payment', ['transaction' => $transaction->order_number]);
        }
    
        // Jika status payment sudah Paid, maka redirect ke transaction payment success page
        if ($payment->payment_status === 'Paid') {
            return redirect()->route('transactions.payment-success', $transaction->order_number);
        }

        return $next($request);
    }
}
