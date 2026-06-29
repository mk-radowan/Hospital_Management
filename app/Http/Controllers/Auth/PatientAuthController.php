<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class PatientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.patient.login');
    }

    public function showRegisterForm()
    {
        return view('auth.patient.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:15'],
            'cnic' => ['nullable', 'string', 'max:15', 'unique:users'],
            'address' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'cnic' => $request->cnic,
            'address' => $request->address,
            'role' => 'patient',
        ]);

        // Create patient profile immediately
        $patient = Patient::create([
            'user_id' => $user->id,
        ]);

        Auth::guard('patient')->login($user);

        return redirect()->route('patient.dashboard')
            ->with('success', 'Registration successful! Welcome to Hospitally.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['role'] = 'patient';
        $credentials['is_active'] = true;

        if (Auth::guard('patient')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('patient.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}