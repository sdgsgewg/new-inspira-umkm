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
        
        // Redirect ke home page jika yang akses bukan buyer
        if ($transaction->buyer->id !== $user->id) {
            return redirect()->route('home');
        }
    
        return $next($request);
    }
}
