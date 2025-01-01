<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // periksa apakah pengguna sudah sesuai rolenya
        $user = Auth::user();

        if ($user->is_admin) {
            $userRole = 'admin';
        } else {
            $userRole = 'buyer';
        }

        if ($userRole !== $role) {
            return redirect()->route('home');
        }
        
        return $next($request);
    }
}
