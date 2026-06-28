@extends('layouts.dashboard')

@section('title', 'Doctor Details - ' . $doctor->user->name)

@push('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin-bottom: 1rem;
        border: 4px solid rgba(255, 255, 255, 0.3);
    }

    .info-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .info-card h5 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #4a5568;
    }

    .info-value {
        color: #2d3748;
        font-weight: 400;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        border: 1px solid #e2e8f0;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #4a5568;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .profile-header {
            padding: 1.5rem;
            text-align: center;
        }

        .action-buttons {
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Doctors</a></li>
        <li class="breadcrumb-item active">{{ $doctor->user->name }}</li>
    </ol>
</nav>

<!-- Profile Header -->
<div class="profile-header">
    <div class="row align-items-center">
        <div class="col-md-auto text-center text-md-start">
            <div class="profile-avatar">
                <i class="bi bi-person-badge"></i>
            </div>
        </div>
        <div class="col-md">
            <h1 class="mb-1">{{ $doctor->user->name }}</h1>
            <p class="mb-2 opacity-90">{{ $doctor->specialization }}</p>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="status-badge {{ $doctor->is_available && $doctor->user->is_active ? 'status-active' : 'status-inactive' }}">
                    {{ $doctor->is_available && $doctor->user->is_active ? 'Active' : 'Inactive' }}
                </span>
                <span class="badge bg-light text-dark">{{ $doctor->experience_years }} Years Experience</span>
            </div>
        </div>
        <div class="col-md-auto mt-3 mt-md-0">
            <div class="action-buttons">
                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-light">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $doctor->appointments()->count() }}</div>
        <div class="stat-label">Total Appointments</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $doctor->appointments()->where('status', 'completed')->count() }}</div>
        <div class="stat-label">Completed</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $doctor->appointments()->where('appointment_date', '>=', now()->startOfMonth())->count() }}</div>
        <div class="stat-label">This Month</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">₨{{ number_format($doctor->consultation_fee) }}</div>
        <div class="stat-label">Consultation Fee</div>
    </div>
</div>

<div class="row">
    <!-- Personal Information -->
    <div class="col-lg-6">
        <div class="info-card">
            <h5>
                <i class="bi bi-person text-primary"></i>
                Personal Information
            </h5>
            <div class="info-item">
                <span class="info-label">Full Name</span>
                <span class="info-value">{{ $doctor->user->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $doctor->user->email }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Phone</span>
                <span class="info-value">{{ $doctor->phone ?? 'Not provided' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Gender</span>
                <span class="info-value">{{ ucfirst($doctor->gender ?? 'Not specified') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Date of Birth</span>
                <span class="info-value">{{ $doctor->date_of_birth ? $doctor->date_of_birth->format('M d, Y') : 'Not provided' }}</span>
            </div>
        </div>
    </div>

    <!-- Professional Information -->
    <div class="col-lg-6">
        <div class="info-card">
            <h5>
                <i class="bi bi-briefcase text-success"></i>
                Professional Information
            </h5>
            <div class="info-item">
                <span class="info-label">Specialization</span>
                <span class="info-value">{{ $doctor->specialization }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Qualification</span>
                <span class="info-value">{{ $doctor->qualification }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Experience</span>
                <span class="info-value">{{ $doctor->experience_years }} years</span>
            </div>
            <div class="info-item">
                <span class="info-label">Consultation Fee</span>
                <span class="info-value">₨{{ number_format($doctor->consultation_fee) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">License Number</span>
                <span class="info-value">{{ $doctor->license_number ?? 'Not provided' }}</span>
            </div>
        </div>
    </div>

    <!-- Address Information -->
    @if($doctor->address)
    <div class="col-lg-6">
        <div class="info-card">
            <h5>
                <i class="bi bi-geo-alt text-warning"></i>
                Address Information
            </h5>
            <div class="info-item">
                <span class="info-label">Address</span>
                <span class="info-value">{{ $doctor->address }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">City</span>
                <span class="info-value">{{ $doctor->city ?? 'Not provided' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">State</span>
                <span class="info-value">{{ $doctor->state ?? 'Not provided' }}</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Account Information -->
    <div class="col-lg-6">
        <div class="info-card">
            <h5>
                <i class="bi bi-shield-check text-info"></i>
                Account Information
            </h5>
            <div class="info-item">
                <span class="info-label">Account Status</span>
                <span class="info-value">
                    <span class="badge {{ $doctor->user->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $doctor->user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Availability</span>
                <span class="info-value">
                    <span class="badge {{ $doctor->is_available ? 'bg-success' : 'bg-warning' }}">
                        {{ $doctor->is_available ? 'Available' : 'Unavailable' }}
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Joined Date</span>
                <span class="info-value">{{ $doctor->user->created_at->format('M d, Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Last Updated</span>
                <span class="info-value">{{ $doctor->updated_at->format('M d, Y \a\t H:i') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Bio/Description -->
@if($doctor->bio)
<div class="info-card">
    <h5>
        <i class="bi bi-file-text text-secondary"></i>
        Biography
    </h5>
    <p class="mb-0 text-muted">{{ $doctor->bio }}</p>
</div>
@endif

<!-- Recent Appointments -->
<div class="info-card">
    <h5>
        <i class="bi bi-calendar-check text-primary"></i>
        Recent Appointments
        <span class="badge bg-primary ms-2">{{ $doctor->appointments()->latest()->limit(5)->count() }}</span>
    </h5>
    
    @if($doctor->appointments()->exists())
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctor->appointments()->with('patient.user')->latest()->limit(5)->get() as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->user->name }}</td>
                        <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>
                            <span class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('admin.appointments.index', ['doctor' => $doctor->id]) }}" class="btn btn-outline-primary btn-sm">
                View All Appointments <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    @else
        <p class="text-muted text-center py-3">No appointments found for this doctor.</p>
    @endif
</div>
@endsection