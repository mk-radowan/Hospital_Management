<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;
        $prescriptions = $patient->prescriptions()
            ->with(['doctor.user', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.prescriptions.index', compact('prescriptions'));
    }

    public function download(Prescription $prescription)
    {
        if ($prescription->patient_id !== auth()->user()->patient->id) {
            abort(403);
        }

        if ($prescription->file_path && Storage::exists($prescription->file_path)) {
            return Storage::download($prescription->file_path);
        }

        return back()->withErrors(['error' => 'Prescription file not found.']);
    }
}