@extends('layouts.dashboard')

@section('title', 'Manage Patients')

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
    <h1 class="h2">Manage Patients</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.patients.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-person-plus"></i> Add New Patient
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($patients->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-people text-muted" style="font-size: 5rem;"></i>
                <h4 class="text-muted mt-3">No Patients Found</h4>
                <p class="text-muted">Patients will appear here when they register or are added by admin.</p>
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary-custom btn-lg">
                    <i class="bi bi-person-plus"></i> Add First Patient
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Contact</th>
                            <th>Age/Gender</th>
                            <th>Blood Group</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-person-circle text-primary-custom fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $patient->user->name }}</h6>
                                        <small class="text-muted">{{ $patient->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($patient->user->phone)
                                    {{ $patient->user->phone }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($patient->date_of_birth)
                                    {{ $patient->date_of_birth->age }} years
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                                @if($patient->gender)
                                    <br><small class="text-muted">{{ ucfirst($patient->gender) }}</small>
                                @endif
                            </td>
                            <td>{{ $patient->blood_group ?: '-' }}</td>
                            <td>
                                @if($patient->user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.patients.toggle-status', $patient) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-{{ $patient->user->is_active ? 'warning' : 'success' }}">
                                            <i class="bi bi-{{ $patient->user->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this patient?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $patients->links() }}
            </div>
        @endif
    </div>
</div>
@endsection