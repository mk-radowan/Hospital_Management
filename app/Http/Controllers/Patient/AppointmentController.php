<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;
        $appointments = $patient->appointments()
            ->with('doctor.user')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')
            ->where('is_available', true)
            ->get();

        return view('patient.appointments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'symptoms' => 'nullable|string|max:500',
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);
        $appointmentDateTime = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);

        // Check if time slot is available
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $appointmentDateTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($existingAppointment) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked.']);
        }

        // Check if doctor is available on this day
        $dayOfWeek = strtolower($appointmentDateTime->format('l'));
        if (!$doctor->isAvailableOnDay($dayOfWeek)) {
            return back()->withErrors(['appointment_date' => 'Doctor is not available on this day.']);
        }

        Appointment::create([
            'patient_id' => auth()->user()->patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $appointmentDateTime,
            'symptoms' => $request->symptoms,
            'consultation_fee' => $doctor->consultation_fee,
        ]);

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Appointment booked successfully!');
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->patient_id !== auth()->user()->patient->id) {
            abort(403);
        }

        if ($appointment->status === 'completed') {
            return back()->withErrors(['error' => 'Cannot cancel completed appointment.']);
        }

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Appointment cancelled successfully.');
    }
}