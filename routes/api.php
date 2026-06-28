<?php

// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Admin dashboard stats API (only for admin users)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/stats', function () {
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