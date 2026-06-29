<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetAuthGuardFromRoute
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        $routeName = $request->route()?->getName();

        if ($routeName && str_starts_with($routeName, 'admin.')) {
            Auth::shouldUse('admin');
        } elseif ($routeName && str_starts_with($routeName, 'doctor.')) {
            Auth::shouldUse('doctor');
        } elseif ($routeName && str_starts_with($routeName, 'patient.')) {
            Auth::shouldUse('patient');
        } elseif ($request->is('admin') || $request->is('admin/*')) {
            Auth::shouldUse('admin');
        } elseif ($request->is('doctor') || $request->is('doctor/*')) {
            Auth::shouldUse('doctor');
        } elseif ($request->is('patient') || $request->is('patient/*') || $request->is('ajax/*')) {
            Auth::shouldUse('patient');
        }

        return $next($request);
    }
}