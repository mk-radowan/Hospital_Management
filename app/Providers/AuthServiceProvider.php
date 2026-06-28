<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Prescription;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Admin gates
        Gate::define('admin-access', function (User $user) {
            return $user->role === 'admin' && $user->is_active;
        });

        // Doctor gates
        Gate::define('doctor-access', function (User $user) {
            return $user->role === 'doctor' && $user->is_active;
        });

        Gate::define('manage-appointments', function (User $user, Appointment $appointment) {
            return $user->role === 'doctor' && $user->doctor && $user->doctor->id === $appointment->doctor_id;
        });

        Gate::define('create-prescription', function (User $user, Appointment $appointment) {
            return $user->role === 'doctor' && 
                   $user->doctor && 
                   $user->doctor->id === $appointment->doctor_id &&
                   in_array($appointment->status, ['confirmed', 'completed']);
        });

        // Patient gates
        Gate::define('patient-access', function (User $user) {
            return $user->role === 'patient' && $user->is_active;
        });

        Gate::define('view-appointment', function (User $user, Appointment $appointment) {
            return ($user->role === 'patient' && $user->patient && $user->patient->id === $appointment->patient_id) ||
                   ($user->role === 'doctor' && $user->doctor && $user->doctor->id === $appointment->doctor_id) ||
                   ($user->role === 'admin');
        });

        Gate::define('view-prescription', function (User $user, Prescription $prescription) {
            return ($user->role === 'patient' && $user->patient && $user->patient->id === $prescription->patient_id) ||
                   ($user->role === 'doctor' && $user->doctor && $user->doctor->id === $prescription->doctor_id) ||
                   ($user->role === 'admin');
        });

        Gate::define('cancel-appointment', function (User $user, Appointment $appointment) {
            return $user->role === 'patient' && 
                   $user->patient && 
                   $user->patient->id === $appointment->patient_id &&
                   in_array($appointment->status, ['pending', 'confirmed']) &&
                   $appointment->appointment_date > now()->toDateString();
        });
    }
}