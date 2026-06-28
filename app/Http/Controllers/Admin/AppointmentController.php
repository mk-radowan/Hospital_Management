<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient.user', 'doctor.user']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->date_from) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->paginate(15);

        $doctors = Doctor::with('user')->get();
        $statuses = Appointment::getStatuses();

        return view('admin.appointments.index', compact('appointments', 'doctors', 'statuses'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->where('is_available', true)->get();

        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
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

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $appointmentDateTime,
            'symptoms' => $request->symptoms,
            'consultation_fee' => $doctor->consultation_fee,
            'status' => 'confirmed', // Admin can directly confirm
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully!');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user', 'prescription']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->where('is_available', true)->get();

        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'symptoms' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
        ]);

        $appointmentDateTime = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);

        // Check if time slot is available (excluding current appointment)
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $appointmentDateTime)
            ->where('id', '!=', $appointment->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($existingAppointment) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked.']);
        }

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $appointmentDateTime,
            'status' => $request->status,
            'symptoms' => $request->symptoms,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Appointment status updated successfully!');
    }
}