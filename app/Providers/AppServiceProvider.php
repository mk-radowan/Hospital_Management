<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Route model bindings
        Route::model('patient', \App\Models\Patient::class);
        Route::model('doctor', \App\Models\Doctor::class);
        Route::model('appointment', \App\Models\Appointment::class);
        Route::model('prescription', \App\Models\Prescription::class);
        
        // Custom route patterns
        Route::pattern('id', '[0-9]+');
    }
}