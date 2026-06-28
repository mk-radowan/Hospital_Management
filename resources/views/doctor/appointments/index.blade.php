@extends('layouts.dashboard')

@section('title', 'Appointments Management')

@section('sidebar')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('doctor.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('doctor.appointments.index') }}">
            <i class="bi bi-calendar-check"></i> Appointments
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Appointments Management</h1>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-custom me-2">Filter</button>
                        <a href="{{ route('doctor.appointments.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($appointments->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted" style="font-size: 5rem;"></i>
                <h4 class="text-muted mt-3">No Appointments Found</h4>
                <p class="text-muted">No appointments match your current filters.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Patient</th>
                            <th>Contact</th>
                            <th>Symptoms</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>
                                <strong>{{ $appointment->appointment_date->format('M d, Y') }}</strong><br>
                                <small class="text-muted">{{ $appointment->appointment_time->format('h:i A') }}</small>
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
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('doctor.appointments.show', $appointment) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($appointment->status === 'pending')
                                        <form action="{{ route('doctor.appointments.confirm', $appointment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-success" title="Confirm">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if(in_array($appointment->status, ['confirmed']))
                                        <form action="{{ route('doctor.appointments.complete', $appointment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-primary" title="Mark Complete">
                                                <i class="bi bi-check-circle"></i>
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
            
            <div class="mt-4">
                {{ $appointments->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection