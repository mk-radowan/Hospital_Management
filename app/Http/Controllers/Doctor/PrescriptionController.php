<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    public function create(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }

        return view('doctor.prescriptions.create', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'medications' => 'nullable|array',
            'medications.*' => 'string',
            'instructions' => 'nullable|string',
            'prescription_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('prescription_file')) {
            $filePath = $request->file('prescription_file')
                ->store('prescriptions', 'public');
        }

        Prescription::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'diagnosis' => $request->diagnosis,
            'medications' => array_filter($request->medications ?? []),
            'instructions' => $request->instructions,
            'file_path' => $filePath,
        ]);

        // Mark appointment as completed
        $appointment->update(['status' => 'completed']);

        return redirect()->route('doctor.appointments.show', $appointment)
            ->with('success', 'Prescription created successfully!');
    }
}