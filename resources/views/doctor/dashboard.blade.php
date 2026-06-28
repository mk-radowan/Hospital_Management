

@extends('layouts.dashboard')

@section('title', 'Doctor Dashboard')

@section('sidebar')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('doctor.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('doctor.appointments.index') }}">
            <i class="bi bi-calendar-check"></i> Appointments
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Welcome, {{ auth()->user()->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="badge bg-primary fs-6">{{ auth()->user()->doctor->specialization }}</span>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-subtitle mb-2">Total Patients</h6>
                        <h2 class="card-title mb-0">{{ $stats['total_patients'] }}</h2>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="bi bi-people fs-1"></i>
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
                        <h6 class="card-subtitle mb-2">Pending</h6>
                        <h2 class="card-title mb-0">{{ $stats['pending_appointments'] }}</h2>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="bi bi-clock fs-1"></i>
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
                        <h2 class="card-title mb-0">{{ $stats['completed_appointments'] }}</h2>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="bi bi-check-circle fs-1"></i>
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
                        <h6 class="card-subtitle mb-2">Today's Apps</h6>
                        <h2 class="card-title mb-0">{{ $todayAppointments->count() }}</h2>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="bi bi-calendar-day fs-1"></i>
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
                <h5 class="mb-0">Today's Appointments</h5>
                <span class="badge bg-primary">{{ now()->format('M d, Y') }}</span>
            </div>
            <div class="card-body">
                @if($todayAppointments->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No appointments scheduled for today</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Patient</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayAppointments as $appointment)
                                <tr>
                                    <td>
                                        <strong>{{ $appointment->appointment_time->format('h:i A') }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $appointment->patient->user->name }}</strong><br>
                                        @if($appointment->patient->gender)
                                            <small class="text-muted">{{ ucfirst($appointment->patient->gender) }}</small>
                                        @endif
                                        @if($appointment->patient->date_of_birth)
                                            <small class="text-muted">• {{ $appointment->patient->date_of_birth->age }} years</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($appointment->patient->user->phone)
                                            {{ $appointment->patient->user->phone }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($appointment->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($appointment->status === 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('doctor.appointments.show', $appointment) }}" class="btn btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($appointment->status === 'pending')
                                                <form action="{{ route('doctor.appointments.confirm', $appointment) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-success">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
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
            <div class="card-header">
                <h5 class="mb-0">Upcoming Appointments</h5>
            </div>
            <div class="card-body">
                @if($upcomingAppointments->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-check text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">No upcoming appointments</p>
                    </div>
                @else
                    @foreach($upcomingAppointments->take(5) as $appointment)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ $appointment->appointment_date->format('d') }}
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $appointment->patient->user->name }}</h6>
                                <small class="text-muted">
                                    {{ $appointment->appointment_date->format('M d') }} • 
                                    {{ $appointment->appointment_time->format('h:i A') }}
                                </small>
                            </div>
                            <div class="flex-shrink-0">
                                @if($appointment->status === 'pending')
                                    <span class="badge bg-warning">New</span>
                                @else
                                    <span class="badge bg-success">Confirmed</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    @if($upcomingAppointments->count() > 5)
                        <div class="text-center">
                            <a href="{{ route('doctor.appointments.index') }}" class="btn btn-sm btn-outline-primary">
                                View All ({{ $upcomingAppointments->count() }} total)
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection