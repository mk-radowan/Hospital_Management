<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.doctor.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Add role and active status to credentials
        $credentials['role'] = 'doctor';
        $credentials['is_active'] = true;

        if (Auth::guard('doctor')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Check if doctor profile exists
            if (!Auth::guard('doctor')->user()?->doctor) {
                Auth::guard('doctor')->logout();
                return back()->withErrors([
                    'email' => 'Doctor profile not found. Please contact administrator.',
                ]);
            }
            
            // Redirect to your dashboard
            return redirect()->route('doctor.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or account is inactive.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('doctor')->logout();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}