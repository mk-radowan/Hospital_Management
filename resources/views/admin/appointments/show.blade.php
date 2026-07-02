@extends('layouts.dashboard')

@section('title', 'Appointment Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Appointment Details</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Appointment Information</h5>
                    @php(
    $statusClass = match ($appointment->status) {
        'pending' => 'bg-warning',
        'confirmed' => 'bg-info',
        'completed' => 'bg-success',
        'cancelled' => 'bg-danger',
        default => 'bg-secondary'
    }
)
                    <span class="badge {{ $statusClass }}">{{ ucfirst($appointment->status) }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Date</p>
                            <p class="fw-semibold">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Time</p>
                            <p class="fw-semibold">{{ $appointment->appointment_time->format('h:i A') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Consultation Fee</p>
                            <p class="fw-semibold text-success">Tk {{ number_format($appointment->consultation_fee, 0) }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Created At</p>
                            <p class="fw-semibold">{{ $appointment->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1 text-muted">Symptoms</p>
                        <div class="border rounded p-3 bg-light">
                            {{ $appointment->symptoms ?: 'No symptoms provided.' }}
                        </div>
                    </div>

                    <div>
                        <p class="mb-1 text-muted">Notes</p>
                        <div class="border rounded p-3 bg-light">
                            {{ $appointment->notes ?: 'No notes added.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Patient</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1 fw-semibold">{{ $appointment->patient->user->name }}</p>
                    <p class="mb-1 text-muted">{{ $appointment->patient->user->email }}</p>
                    @if ($appointment->patient->user->phone)
                        <p class="mb-0 text-muted">{{ $appointment->patient->user->phone }}</p>
                    @endif
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Doctor</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1 fw-semibold">{{ $appointment->doctor->user->name }}</p>
                    <p class="mb-1 text-muted">{{ $appointment->doctor->specialization }}</p>
                    <p class="mb-0 text-muted">{{ $appointment->doctor->user->email }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Prescription</h6>
                </div>
                <div class="card-body">
                    @if ($appointment->prescription)
                        <p class="mb-1 text-muted">Diagnosis</p>
                        <p class="mb-2">{{ $appointment->prescription->diagnosis ?: 'N/A' }}</p>
                        <p class="mb-1 text-muted">Instructions</p>
                        <p class="mb-0">{{ $appointment->prescription->instructions ?: 'N/A' }}</p>
                    @else
                        <p class="mb-0 text-muted">No prescription created yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
