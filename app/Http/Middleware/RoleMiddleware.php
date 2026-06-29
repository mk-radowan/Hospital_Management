<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $guards = ['admin', 'doctor', 'patient', 'web'];
        $authenticatedGuard = null;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $authenticatedGuard = $guard;
                break;
            }
        }

        if (!$authenticatedGuard) {
            return redirect()->route('home');
        }

        $user = Auth::guard($authenticatedGuard)->user();

        // Check if user has the required role
        if ($user->role !== $role) {
            // Redirect based on user's actual role
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'doctor' => redirect()->route('doctor.dashboard'),
                'patient' => redirect()->route('patient.dashboard'),
                default => redirect()->route('home'),
            };
        }

        // Check if user is active
        if (!$user->is_active) {
            Auth::guard($authenticatedGuard)->logout();
            return redirect()->route('home')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}