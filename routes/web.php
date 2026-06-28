<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\Auth\DoctorAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use Carbon\Carbon;

// Patient Controllers
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\PrescriptionController as PatientPrescriptionController;
use App\Http\Controllers\Patient\ProfileController as PatientProfileController;

// Doctor Controllers
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Doctor\PrescriptionController as DoctorPrescriptionController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;

// ====================================
// PUBLIC ROUTES
// ====================================

// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// ====================================
// AUTHENTICATION ROUTES
// ====================================

// Patient Authentication Routes
Route::prefix('patient')->name('patient.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [PatientAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [PatientAuthController::class, 'login']);
        Route::get('register', [PatientAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [PatientAuthController::class, 'register']);
    });
    
    Route::post('logout', [PatientAuthController::class, 'logout'])->name('logout');
});

// Doctor Authentication Routes
Route::prefix('doctor')->name('doctor.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [DoctorAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [DoctorAuthController::class, 'login']);
    });
    
    Route::post('logout', [DoctorAuthController::class, 'logout'])->name('logout');
});

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login']);
    });
    
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Replace your AJAX routes section in routes/web.php with this FINAL corrected version:

Route::middleware(['auth', 'role:patient'])->prefix('ajax')->name('ajax.')->group(function () {
    
    // Get doctor details for appointment booking
    // Changed parameter name to avoid automatic model binding
    Route::get('doctors/{doctorId}', function ($doctorId) {
        try {
            // Now $doctorId is actually just the ID, not the model
            $doctor = \App\Models\Doctor::with('user')->findOrFail($doctorId);
            
            return response()->json([
                'success' => true,
                'id' => $doctor->id,
                'name' => $doctor->user->name,
                'specialization' => $doctor->specialization,
                'qualification' => $doctor->qualification,
                'consultation_fee' => (float) $doctor->consultation_fee,
                'available_days' => $doctor->available_days ?? [],
                'available_time_start' => $doctor->available_time_start,
                'available_time_end' => $doctor->available_time_end,
            ]);
            
        } catch (\Exception $e) {
            // Now this will work correctly since $doctorId is actually an ID
            \Log::error('Doctor details fetch error', [
                'doctor_id' => $doctorId,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Unable to load doctor details'
            ], 500);
        }
    })->name('doctors.show');
    
    // Get available time slots for a doctor on a specific date  
    // Changed parameter name to avoid automatic model binding
    Route::get('doctors/{doctorId}/available-slots', function (Request $request, $doctorId) {
        try {
            // Now $doctorId is actually just the ID, not the model
            $doctor = \App\Models\Doctor::findOrFail($doctorId);
            $date = $request->query('date');
            
            if (!$date) {
                return response()->json([
                    'success' => false,
                    'error' => 'Date parameter is required'
                ], 400);
            }

            $carbonDate = \Carbon\Carbon::parse($date);
            $dayOfWeek = strtolower($carbonDate->format('l'));
            
            // available_days is already properly cast as array
            $availableDays = $doctor->available_days ?? [];
            $availableDaysLower = array_map('strtolower', $availableDays);
            
            // Check if doctor is available on this day
            if (!in_array($dayOfWeek, $availableDaysLower)) {
                return response()->json([
                    'success' => true,
                    'slots' => [],
                    'message' => 'Doctor is not available on this day'
                ]);
            }
            
            // Get booked slots for this date
            $bookedSlots = \App\Models\Appointment::where('doctor_id', $doctorId)
                ->where('appointment_date', $date)
                ->whereIn('status', ['pending', 'confirmed'])
                ->pluck('appointment_time')
                ->map(function ($time) {
                    return \Carbon\Carbon::parse($time)->format('H:i');
                })
                ->toArray();
            
            // Generate available slots (30-minute intervals)
            $start = \Carbon\Carbon::parse($doctor->available_time_start);
            $end = \Carbon\Carbon::parse($doctor->available_time_end);
            $slots = [];
            
            $current = $start->copy();
            while ($current->lt($end)) {
                $timeSlot = $current->format('H:i');
                if (!in_array($timeSlot, $bookedSlots)) {
                    $slots[] = [
                        'time' => $timeSlot,
                        'display' => $current->format('g:i A')
                    ];
                }
                $current->addMinutes(30);
            }
            
            return response()->json([
                'success' => true,
                'slots' => $slots
            ]);
            
        } catch (\Exception $e) {
            // Now this will work correctly since $doctorId is actually an ID
            \Log::error('Available slots fetch error', [
                'doctor_id' => $doctorId,
                'date' => $request->query('date'),
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Unable to load available time slots'
            ], 500);
        }
    })->name('doctors.slots');
});

// ====================================
// PATIENT ROUTES
// ====================================

Route::prefix('patient')->name('patient.')->middleware(['auth', 'role:patient'])->group(function () {
    // Dashboard
    Route::get('dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('profile', [PatientProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [PatientProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [PatientProfileController::class, 'update'])->name('profile.update');
    
    // Appointments
    Route::get('appointments', [PatientAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('appointments/create', [PatientAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('appointments', [PatientAppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('appointments/{appointment}/cancel', [PatientAppointmentController::class, 'cancel'])->name('appointments.cancel');
    
    // Prescriptions
    Route::get('prescriptions', [PatientPrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('prescriptions/{prescription}/download', [PatientPrescriptionController::class, 'download'])->name('prescriptions.download');
});

// ====================================
// DOCTOR ROUTES
// ====================================

Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'role:doctor'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    
    // Appointments Management
    Route::get('appointments', [DoctorAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('appointments/{appointment}', [DoctorAppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('appointments/{appointment}/confirm', [DoctorAppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::patch('appointments/{appointment}/complete', [DoctorAppointmentController::class, 'complete'])->name('appointments.complete');
    
    // Prescriptions
    Route::get('appointments/{appointment}/prescriptions/create', [DoctorPrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('appointments/{appointment}/prescriptions', [DoctorPrescriptionController::class, 'store'])->name('prescriptions.store');
});

// ====================================
// ADMIN ROUTES
// ====================================

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Doctor Management
    Route::get('doctors', [AdminDoctorController::class, 'index'])->name('doctors.index');
    Route::get('doctors/create', [AdminDoctorController::class, 'create'])->name('doctors.create');
    Route::post('doctors', [AdminDoctorController::class, 'store'])->name('doctors.store');
    Route::get('doctors/{doctor}', [AdminDoctorController::class, 'show'])->name('doctors.show');
    Route::get('doctors/{doctor}/edit', [AdminDoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('doctors/{doctor}', [AdminDoctorController::class, 'update'])->name('doctors.update');
    Route::delete('doctors/{doctor}', [AdminDoctorController::class, 'destroy'])->name('doctors.destroy');
    Route::patch('doctors/{doctor}/toggle-status', [AdminDoctorController::class, 'toggleStatus'])->name('doctors.toggle-status');
    
    // Patient Management
    Route::get('patients', [AdminPatientController::class, 'index'])->name('patients.index');
    Route::get('patients/create', [AdminPatientController::class, 'create'])->name('patients.create');
    Route::post('patients', [AdminPatientController::class, 'store'])->name('patients.store');
    Route::get('patients/{patient}', [AdminPatientController::class, 'show'])->name('patients.show');
    Route::get('patients/{patient}/edit', [AdminPatientController::class, 'edit'])->name('patients.edit');
    Route::put('patients/{patient}', [AdminPatientController::class, 'update'])->name('patients.update');
    Route::delete('patients/{patient}', [AdminPatientController::class, 'destroy'])->name('patients.destroy');
    Route::patch('patients/{patient}/toggle-status', [AdminPatientController::class, 'toggleStatus'])->name('patients.toggle-status');
    
    // Appointment Management
    Route::get('appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('appointments/create', [AdminAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('appointments', [AdminAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('appointments/{appointment}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
    Route::get('appointments/{appointment}/edit', [AdminAppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('appointments/{appointment}', [AdminAppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::patch('appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.update-status');
    
    // Admin stats API for dashboard
    Route::get('/api/admin/stats', function () {
        return response()->json([
            'total_patients' => \App\Models\Patient::count(),
            'total_doctors' => \App\Models\Doctor::count(),
            'total_appointments' => \App\Models\Appointment::count(),
            'pending_appointments' => \App\Models\Appointment::where('status', 'pending')->count(),
            'completed_appointments' => \App\Models\Appointment::where('status', 'completed')->count(),
            'cancelled_appointments' => \App\Models\Appointment::where('status', 'cancelled')->count(),
        ]);
    });
});

// ====================================
// FALLBACK ROUTES
// ====================================

// Redirect users to appropriate dashboards if they access wrong URLs
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            default => redirect()->route('home'),
        };
    });


    
});

