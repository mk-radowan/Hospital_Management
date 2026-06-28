<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = auth()->user()->doctor;
        
        if (!$doctor) {
            return redirect()->route('doctor.login')->withErrors(['error' => 'Doctor profile not found.']);
        }
        
        $todayAppointments = $doctor->appointments()
            ->with('patient.user')
            ->whereDate('appointment_date', Carbon::today())
            ->orderBy('appointment_time')
            ->get();

        $upcomingAppointments = $doctor->appointments()
            ->with('patient.user')
            ->where('appointment_date', '>', Carbon::today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $stats = [
            'total_patients' => $doctor->appointments()->distinct('patient_id')->count(),
            'pending_appointments' => $doctor->appointments()->where('status', 'pending')->count(),
            'completed_appointments' => $doctor->appointments()->where('status', 'completed')->count(),
        ];

        return view('doctor.dashboard', compact('todayAppointments', 'upcomingAppointments', 'stats'));
    }
}