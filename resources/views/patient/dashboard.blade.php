@extends('layouts.dashboard')

@section('title', 'Patient Dashboard')

@section('sidebar')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('patient.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patient.appointments.index') }}">
            <i class="bi bi-calendar-check"></i> My Appointments
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patient.appointments.create') }}">
            <i class="bi bi-calendar-plus"></i> Book Appointment
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patient.prescriptions.index') }}">
            <i class="bi bi-file-medical"></i> My Prescriptions
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patient.profile.show') }}">
            <i class="bi bi-person"></i> My Profile
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Welcome, {{ auth()->user()->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-calendar-plus"></i> Book New Appointment
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-subtitle mb-2">Upcoming Appointments</h6>
                        <h2 class="card-title mb-0">{{ $upcomingAppointments->count() }}</h2>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="bi bi-calendar-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card stats-card-green h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-subtitle mb-2">Completed</h6>
                        <h2 class="card-title mb-0">{{ $pastAppointments->count() }}</h2>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card stats-card-orange h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-subtitle mb-2">Prescriptions</h6>
                        <h2 class="card-title mb-0">{{ $prescriptions->count() }}</h2>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="bi bi-file-medical fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card stats-card-red h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-subtitle mb-2">Profile Status</h6>
                        <h2 class="card-title mb-0">
                            @if(auth()->user()->patient && auth()->user()->patient->date_of_birth)
                                <i class="bi bi-check-lg"></i>
                            @else
                                <i class="bi bi-exclamation-lg"></i>
                            @endif
                        </h2>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="bi bi-person fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Upcoming Appointments</h5>
                <a href="{{ route('patient.appointments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($upcomingAppointments->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No upcoming appointments</p>
                        <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary-custom">Book Your First Appointment</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingAppointments as $appointment)
                                <tr>
                                    <td>
                                        <strong>{{ $appointment->doctor->user->name }}</strong><br>
                                        <small class="text-muted">{{ $appointment->doctor->specialization }}</small>
                                    </td>
                                    <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                    <td>{{ $appointment->appointment_time->format('h:i A') }}</td>
                                    <td>
                                        @if($appointment->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($appointment->status === 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span>
                                        @endif
                                    </td>
                                    <td>₨{{ number_format($appointment->consultation_fee, 0) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Prescriptions</h5>
                <a href="{{ route('patient.prescriptions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($prescriptions->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-file-medical text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No prescriptions yet</p>
                    </div>
                @else
                    @foreach($prescriptions->take(3) as $prescription)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-file-medical-fill text-primary-custom fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $prescription->doctor->user->name }}</h6>
                                <small class="text-muted">{{ $prescription->prescription_date->format('M d, Y') }}</small>
                            </div>
                            @if($prescription->file_path)
                                <div class="flex-shrink-0">
                                    <a href="{{ route('patient.prescriptions.download', $prescription) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        @if(!auth()->user()->patient || !auth()->user()->patient->date_of_birth)
        <div class="card mt-3 border-warning">
            <div class="card-header bg-warning text-dark">
                <i class="bi bi-exclamation-triangle"></i> Complete Your Profile
            </div>
            <div class="card-body">
                <p class="card-text">Please complete your profile to access all features.</p>
                <a href="{{ route('patient.profile.edit') }}" class="btn btn-warning">Complete Profile</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection