@extends('layouts.dashboard')
@section('title', 'Manage Doctors')
@section('sidebar')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.doctors.index') }}">
            <i class="bi bi-person-badge"></i> Doctors
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.patients.index') }}">
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
    <h1 class="h2">Manage Doctors</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-person-plus"></i> Add New Doctor
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($doctors->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-person-badge text-muted" style="font-size: 5rem;"></i>
                <h4 class="text-muted mt-3">No Doctors Found</h4>
                <p class="text-muted">Start by adding your first doctor to the system.</p>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary-custom btn-lg">
                    <i class="bi bi-person-plus"></i> Add First Doctor
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>Experience</th>
                            <th>Fee</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-person-circle text-primary-custom fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $doctor->user->name }}</h6>
                                        <small class="text-muted">{{ $doctor->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $doctor->specialization }}</strong><br>
                                <small class="text-muted">{{ $doctor->qualification }}</small>
                            </td>
                            <td>{{ $doctor->experience_years }} years</td>
                            <td>Tk {{ number_format($doctor->consultation_fee, 0) }}</td>
                            <td>
                                @if($doctor->is_available && $doctor->user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.doctors.toggle-status', $doctor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-{{ $doctor->is_available ? 'warning' : 'success' }}">
                                            <i class="bi bi-{{ $doctor->is_available ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this doctor?')">
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
                {{ $doctors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection