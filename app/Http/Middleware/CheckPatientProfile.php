<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPatientProfile
{
    /**
     * Handle an incoming request.
     * Ensures patient has completed their profile before accessing certain features
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'patient') {
            $patient = auth()->user()->patient;
            
            // Check if essential profile fields are missing
            if (!$patient || !$patient->date_of_birth || !$patient->gender) {
                return redirect()->route('patient.profile.edit')
                    ->with('warning', 'Please complete your profile to access this feature.');
            }
        }

        return $next($request);
    }
}