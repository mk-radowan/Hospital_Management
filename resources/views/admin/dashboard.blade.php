@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    /* Fix white space issues */
    .main-content {
        margin-left: var(--sidebar-width, 280px);
        min-height: calc(100vh - 76px);
        padding: 2rem;
        background-color: #f8f9fa;
        width: calc(100% - var(--sidebar-width, 280px)) !important;
        overflow-x: hidden;
    }

    .content-wrapper {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,.05);
        margin: 0;
        width: 100% !important;
        box-sizing: border-box;
    }

    /* Ensure full width usage */
    .container-fluid {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: none !important;
    }

    .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
    }

    .col-md-3, .col-md-6 {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admin Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary-custom">
                    <i class="bi bi-person-plus"></i> Add Doctor
                </a>
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
            <div class="card stats-card stats-card-green h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-subtitle mb-2">Total Doctors</h6>
                            <h2 class="card-title mb-0">{{ $stats['total_doctors'] }}</h2>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-person-badge fs-1"></i>
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
                            <h6 class="card-subtitle mb-2">Total Appointments</h6>
                            <h2 class="card-title mb-0">{{ $stats['total_appointments'] }}</h2>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-calendar-check fs-1"></i>
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
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Appointment Status Breakdown</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-3">
                            <h4 class="text-warning">{{ $stats['pending_appointments'] }}</h4>
                            <small class="text-muted">Pending</small>
                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-success">{{ $stats['completed_appointments'] }}</h4>
                            <small class="text-muted">Completed</small>
                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-danger">{{ $stats['cancelled_appointments'] }}</h4>
                            <small class="text-muted">Cancelled</small>
                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-primary">{{ $stats['total_appointments'] }}</h4>
                            <small class="text-muted">Total</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Appointments</h5>
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($recentAppointments->isEmpty())
                        <p class="text-muted text-center py-3">No recent appointments</p>
                    @else
                        @foreach($recentAppointments->take(5) as $appointment)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    @if($appointment->status === 'pending')
                                        <span class="badge bg-warning">P</span>
                                    @elseif($appointment->status === 'confirmed')
                                        <span class="badge bg-success">C</span>
                                    @elseif($appointment->status === 'completed')
                                        <span class="badge bg-primary">D</span>
                                    @else
                                        <span class="badge bg-danger">X</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $appointment->patient->user->name }}</h6>
                                    <small class="text-muted">
                                        with {{ $appointment->doctor->user->name }} • 
                                        {{ $appointment->appointment_date->format('M d') }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection