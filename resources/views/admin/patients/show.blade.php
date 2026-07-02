@extends('layouts.dashboard')

@section('title', 'Patient Details')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.doctors.index') }}">
                <i class="bi bi-person-badge"></i> Doctors
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.patients.index') }}">
                <i class="bi bi-people"></i> Patients
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.appointments.index') }}">
                <i class="bi bi-calendar-check"></i> Appointments
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Patient Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-primary-custom me-2">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Patients
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Name:</strong> {{ $patient->user->name }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ $patient->user->email }}</p>
                    <p class="mb-2"><strong>Phone:</strong> {{ $patient->user->phone ?: 'N/A' }}</p>
                    <p class="mb-2"><strong>CNIC:</strong> {{ $patient->user->cnic ?: 'N/A' }}</p>
                    <p class="mb-2"><strong>Address:</strong> {{ $patient->user->address ?: 'N/A' }}</p>
                    <p class="mb-2"><strong>Date of Birth:</strong>
                        {{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                    <p class="mb-2"><strong>Age:</strong>
                        {{ $patient->date_of_birth ? $patient->date_of_birth->age . ' years' : 'N/A' }}</p>
                    <p class="mb-2"><strong>Gender:</strong> {{ $patient->gender ? ucfirst($patient->gender) : 'N/A' }}
                    </p>
                    <p class="mb-2"><strong>Blood Group:</strong> {{ $patient->blood_group ?: 'N/A' }}</p>
                    <p class="mb-2"><strong>Emergency Contact:</strong> {{ $patient->emergency_contact ?: 'N/A' }}</p>
                    <p class="mb-0"><strong>Status:</strong>
                        @if ($patient->user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Medical History</h5>
                </div>
                <div class="card-body">
                    {{ $patient->medical_history ?: 'No medical history provided.' }}
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Appointments</h5>
                    <span class="badge bg-secondary">{{ $patient->appointments->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if ($patient->appointments->isEmpty())
                        <p class="p-3 text-muted mb-0">No appointments found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Doctor</th>
                                        <th>Status</th>
                                        <th>Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient->appointments->sortByDesc('appointment_date')->take(5) as $appointment)
                                        <tr>
                                            <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                            <td>{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : ($appointment->status === 'confirmed' ? 'info' : 'warning')) }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </td>
                                            <td>Tk {{ number_format($appointment->consultation_fee, 0) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Prescriptions</h5>
                    <span class="badge bg-secondary">{{ $patient->prescriptions->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if ($patient->prescriptions->isEmpty())
                        <p class="p-3 text-muted mb-0">No prescriptions found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Doctor</th>
                                        <th>Diagnosis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient->prescriptions->sortByDesc('prescription_date')->take(5) as $prescription)
                                        <tr>
                                            <td>{{ $prescription->prescription_date ? $prescription->prescription_date->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td>{{ $prescription->doctor->user->name ?? 'N/A' }}</td>
                                            <td>{{ $prescription->diagnosis ?: 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
