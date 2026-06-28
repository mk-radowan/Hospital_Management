<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        $user = auth()->user();

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
            auth()->logout();
            return redirect()->route('home')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}