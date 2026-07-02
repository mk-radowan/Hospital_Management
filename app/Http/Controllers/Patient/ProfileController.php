<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        return view('patient.profile.show');
    }

    public function edit()
    {
        $user = auth()->user();
        $patient = $user->getPatient();

        return view('patient.profile.edit', compact('patient'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $patient = $user->getPatient();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'emergency_contact' => 'nullable|string|max:15',
            'medical_history' => 'nullable|string',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address']));
        
        if ($patient) {
            $patient->update($request->only([
                'date_of_birth', 'gender', 'blood_group',
                'emergency_contact', 'medical_history'
            ]));
        }

        return redirect()->route('patient.profile.show')
            ->with('success', 'Profile updated successfully!');
    }
}