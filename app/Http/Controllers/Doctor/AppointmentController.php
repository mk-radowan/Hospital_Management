<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $doctor = auth()->user()->doctor;
        $query = $doctor->appointments()->with('patient.user');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return view('doctor.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }

        $appointment->load(['patient.user', 'prescription']);
        
        return view('doctor.appointments.show', compact('appointment'));
    }

    public function confirm(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }

        $appointment->update(['status' => 'confirmed']);

        return back()->with('success', 'Appointment confirmed successfully.');
    }

    public function complete(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }

        $appointment->update(['status' => 'completed']);

        return back()->with('success', 'Appointment marked as completed.');
    }
}