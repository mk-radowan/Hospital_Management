<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDoctorAvailability
{
    /**
     * Handle an incoming request.
     * Ensures doctor is marked as available before accessing certain features
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'doctor') {
            $doctor = auth()->user()->doctor;
            
            if (!$doctor || !$doctor->is_available) {
                return redirect()->route('doctor.dashboard')
                    ->with('warning', 'Your account is currently marked as unavailable. Please contact admin.');
            }
        }

        return $next($request);
    }
}