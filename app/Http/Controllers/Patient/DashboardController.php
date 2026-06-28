<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $patient = auth()->user()->patient;
        
        $upcomingAppointments = $patient->appointments()
            ->with('doctor.user')
            ->where('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->limit(5)
            ->get();

        $pastAppointments = $patient->appointments()
            ->with('doctor.user')
            ->where('appointment_date', '<', Carbon::today())
            ->orWhere('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        $prescriptions = $patient->prescriptions()
            ->with('doctor.user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('patient.dashboard', compact('upcomingAppointments', 'pastAppointments', 'prescriptions'));
    }
}