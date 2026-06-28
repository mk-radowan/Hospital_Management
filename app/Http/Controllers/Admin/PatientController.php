<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'nullable|string|max:15',
            'cnic' => 'nullable|string|max:15|unique:users',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'emergency_contact' => 'nullable|string|max:15',
            'medical_history' => 'nullable|string',
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

        Patient::create([
            'user_id' => $user->id,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'emergency_contact' => $request->emergency_contact,
            'medical_history' => $request->medical_history,
        ]);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient created successfully!');
    }

    public function show(Patient $patient)
    {
        $patient->load('user', 'appointments.doctor.user', 'prescriptions.doctor.user');
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patient->load('user');
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'phone' => 'nullable|string|max:15',
            'cnic' => 'nullable|string|max:15|unique:users,cnic,' . $patient->user_id,
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'emergency_contact' => 'nullable|string|max:15',
            'medical_history' => 'nullable|string',
        ]);

        $patient->user->update($request->only([
            'name', 'email', 'phone', 'cnic', 'address'
        ]));

        $patient->update($request->only([
            'date_of_birth', 'gender', 'blood_group',
            'emergency_contact', 'medical_history'
        ]));

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient updated successfully!');
    }

    public function destroy(Patient $patient)
    {
        $patient->user->delete(); // This will cascade delete the patient
        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient deleted successfully!');
    }

    public function toggleStatus(Patient $patient)
    {
        $patient->user->update(['is_active' => !$patient->user->is_active]);
        $status = $patient->user->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Patient {$status} successfully!");
    }
}