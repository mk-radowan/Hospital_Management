@extends('layouts.dashboard')

@section('title', 'Appointment Details')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('doctor.dashboard') }}">
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
        <h1 class="h2">Appointment Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('doctor.appointments.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Appointments
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Appointment Information</h5>
                    @if ($appointment->status === 'pending')
                        <span class="badge bg-warning fs-6">Pending</span>
                    @elseif($appointment->status === 'confirmed')
                        <span class="badge bg-success fs-6">Confirmed</span>
                    @elseif($appointment->status === 'completed')
                        <span class="badge bg-primary fs-6">Completed</span>
                    @else
                        <span class="badge bg-danger fs-6">Cancelled</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary-custom">Patient Information</h6>
                            <p><strong>Name:</strong> {{ $appointment->patient->user->name }}</p>
                            <p><strong>Email:</strong> {{ $appointment->patient->user->email }}</p>
                            @if ($appointment->patient->user->phone)
                                <p><strong>Phone:</strong> {{ $appointment->patient->user->phone }}</p>
                            @endif
                            @if ($appointment->patient->gender)
                                <p><strong>Gender:</strong> {{ ucfirst($appointment->patient->gender) }}</p>
                            @endif
                            @if ($appointment->patient->date_of_birth)
                                <p><strong>Age:</strong> {{ $appointment->patient->date_of_birth->age }} years</p>
                            @endif
                            @if ($appointment->patient->blood_group)
                                <p><strong>Blood Group:</strong> {{ $appointment->patient->blood_group }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary-custom">Appointment Details</h6>
                            <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y') }}</p>
                            <p><strong>Time:</strong> {{ $appointment->appointment_time->format('h:i A') }}</p>
                            <p><strong>Consultation Fee:</strong> Tk {{ number_format($appointment->consultation_fee, 0) }}
                            </p>
                            <p><strong>Booked On:</strong> {{ $appointment->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    @if ($appointment->symptoms)
                        <div class="mt-3">
                            <h6 class="text-primary-custom">Symptoms/Reason for Visit</h6>
                            <p class="bg-light p-3 rounded">{{ $appointment->symptoms }}</p>
                        </div>
                    @endif

                    @if ($appointment->patient->medical_history)
                        <div class="mt-3">
                            <h6 class="text-primary-custom">Medical History</h6>
                            <p class="bg-light p-3 rounded">{{ $appointment->patient->medical_history }}</p>
                        </div>
                    @endif

                    @if ($appointment->notes)
                        <div class="mt-3">
                            <h6 class="text-primary-custom">Notes</h6>
                            <p class="bg-light p-3 rounded">{{ $appointment->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if ($appointment->prescription)
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Prescription</h5>
                    </div>
                    <div class="card-body">
                        @if ($appointment->prescription->diagnosis)
                            <p><strong>Diagnosis:</strong> {{ $appointment->prescription->diagnosis }}</p>
                        @endif

                        @if ($appointment->prescription->medications)
                            <h6 class="mt-3">Medications:</h6>
                            <ul>
                                @foreach ($appointment->prescription->medications as $medication)
                                    <li>{{ $medication }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($appointment->prescription->instructions)
                            <p><strong>Instructions:</strong> {{ $appointment->prescription->instructions }}</p>
                        @endif

                        @if ($appointment->prescription->file_path)
                            <p><strong>Prescription File:</strong> Available</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    @if ($appointment->status === 'pending')
                        <form action="{{ route('doctor.appointments.confirm', $appointment) }}" method="POST"
                            class="mb-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle"></i> Confirm Appointment
                            </button>
                        </form>
                    @endif

                    @if (in_array($appointment->status, ['confirmed']) && !$appointment->prescription)
                        <a href="{{ route('doctor.prescriptions.create', $appointment) }}"
                            class="btn btn-primary-custom w-100 mb-2">
                            <i class="bi bi-file-medical"></i> Create Prescription
                        </a>
                    @endif

                    @if ($appointment->status === 'confirmed')
                        <form action="{{ route('doctor.appointments.complete', $appointment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="bi bi-check2-circle"></i> Mark as Completed
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
