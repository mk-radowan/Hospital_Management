@extends('layouts.dashboard')

@section('title', 'My Appointments')

@section('sidebar')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patient.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('patient.appointments.index') }}">
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
    <h1 class="h2">My Appointments</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-calendar-plus"></i> Book New Appointment
        </a>
    </div>
</div>

@if($appointments->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-calendar-x text-muted" style="font-size: 5rem;"></i>
        <h4 class="text-muted mt-3">No Appointments Found</h4>
        <p class="text-muted">You haven't booked any appointments yet.</p>
        <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary-custom btn-lg">
            <i class="bi bi-calendar-plus"></i> Book Your First Appointment
        </a>
    </div>
@else
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Date & Time</th>
                            <th>Symptoms</th>
                            <th>Status</th>
                            <th>Fee</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>
                                <strong>{{ $appointment->doctor->user->name }}</strong><br>
                                <small class="text-muted">{{ $appointment->doctor->specialization }}</small>
                            </td>
                            <td>
                                <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong><br>
                                <small class="text-muted">{{ $appointment->appointment_time->format('h:i A') }}</small>
                            </td>
                            <td>
                                @if($appointment->symptoms)
                                    {{ Str::limit($appointment->symptoms, 50) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($appointment->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($appointment->status === 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($appointment->status === 'completed')
                                    <span class="badge bg-primary">Completed</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>₨{{ number_format($appointment->consultation_fee, 0) }}</td>
                            <td>
                                @if(in_array($appointment->status, ['pending', 'confirmed']) && $appointment->appointment_date > now()->toDateString())
                                    <form action="{{ route('patient.appointments.cancel', $appointment) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
@endif
@endsection