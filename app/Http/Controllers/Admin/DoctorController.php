<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
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
            'specialization' => 'required|string',
            'qualification' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'license_number' => 'required|string|unique:doctors',
            'available_days' => 'required|array',
            'available_time_start' => 'required',
            'available_time_end' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'cnic' => $request->cnic,
            'address' => $request->address,
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
            'qualification' => $request->qualification,
            'experience_years' => $request->experience_years,
            'consultation_fee' => $request->consultation_fee,
            'license_number' => $request->license_number,
            'available_days' => $request->available_days,
            'available_time_start' => $request->available_time_start,
            'available_time_end' => $request->available_time_end,
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor created successfully!');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('user', 'appointments.patient.user');
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load('user');
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'phone' => 'nullable|string|max:15',
            'cnic' => 'nullable|string|max:15|unique:users,cnic,' . $doctor->user_id,
            'address' => 'nullable|string',
            'specialization' => 'required|string',
            'qualification' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'license_number' => 'required|string|unique:doctors,license_number,' . $doctor->id,
            'available_days' => 'required|array',
            'available_time_start' => 'required',
            'available_time_end' => 'required',
            'is_available' => 'boolean',
        ]);

        $doctor->user->update($request->only([
            'name', 'email', 'phone', 'cnic', 'address'
        ]));

        $doctor->update($request->only([
            'specialization', 'qualification', 'experience_years',
            'consultation_fee', 'license_number', 'available_days',
            'available_time_start', 'available_time_end', 'is_available'
        ]));

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor updated successfully!');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete(); // This will cascade delete the doctor
        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor deleted successfully!');
    }

    public function toggleStatus(Doctor $doctor)
    {
        $doctor->update(['is_available' => !$doctor->is_available]);
        $status = $doctor->is_available ? 'activated' : 'deactivated';
        
        return back()->with('success', "Doctor {$status} successfully!");
    }
}