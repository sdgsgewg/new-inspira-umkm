<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PaymentSuccessPageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $transaction = $request->route('transaction');
        $payment = $transaction->payment;
    
        // Jika tabel 'payments' belum ada, arahkan ke Payment Page
        if (!$payment) {
            return redirect()->route('transactions.payment', ['transaction' => $transaction->order_number]);
        }
    
        // Jika status pembayaran adalah 'Pending'
        if ($payment->payment_status === 'Pending') {
            // Cek apakah pengguna sudah mengakses Snap Page sebelumnya
            if (session()->has("snap_accessed_{$transaction->id}")) {
                // Arahkan ke Snap Page
                return redirect()->route('transactions.snap', ['transaction' => $transaction->order_number]);
            } else {
                // Tandai bahwa Snap Page telah diakses
                session(["snap_accessed_{$transaction->id}" => true]);
            }
        }
    
        return $next($request);
    }    
}
