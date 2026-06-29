<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware
        $middleware->web(prepend: [
           \App\Http\Middleware\SetAuthGuardFromRoute::class,
        ], append: [
           // \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        // Middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'patient.profile' => \App\Http\Middleware\CheckPatientProfile::class,
            'doctor.available' => \App\Http\Middleware\CheckDoctorAvailability::class,
        ]);

        // Override the guest middleware
        $middleware->redirectGuestsTo('/');
        
        // Override the auth middleware redirect
        $middleware->redirectUsersTo(function ($request) {
            $user = $request->user('admin')
                ?? $request->user('doctor')
                ?? $request->user('patient')
                ?? $request->user();

            return match($user?->role) {
                'admin' => '/admin/dashboard',
                'doctor' => '/doctor/dashboard',
                'patient' => '/patient/dashboard',
                default => '/',
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();