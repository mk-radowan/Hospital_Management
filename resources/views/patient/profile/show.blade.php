@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('sidebar')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patient.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('patient.appointments.index') }}">
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
        <a class="nav-link active" href="{{ route('patient.profile.show') }}">
            <i class="bi bi-person"></i> My Profile
        </a>
    </li>
</ul>
@endsection

@section('content')
<style>
/* Minimal CSS fix for white space without breaking layout */
.profile-wrapper {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
    padding: 0;
    margin: 0;
}

/* Fix Bootstrap row margin issues */
.profile-row {
    margin-left: -12px;
    margin-right: -12px;
    width: calc(100% + 24px);
}

.profile-col {
    padding-left: 12px;
    padding-right: 12px;
}

/* Ensure cards don't overflow */
.card {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .profile-row {
        margin-left: -8px;
        margin-right: -8px;
        width: calc(100% + 16px);
    }
    
    .profile-col {
        padding-left: 8px;
        padding-right: 8px;
    }
}

@media (max-width: 768px) {
    .profile-row {
        margin-left: 0;
        margin-right: 0;
        width: 100%;
    }
    
    .profile-col {
        padding-left: 0;
        padding-right: 0;
        margin-bottom: 1rem;
    }
}
</style>

<div class="profile-wrapper">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Profile</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('patient.profile.edit') }}" class="btn btn-primary-custom">
                <i class="bi bi-pencil"></i> Edit Profile
            </a>
        </div>
    </div>

    <div class="profile-row row">
        <div class="profile-col col-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-circle text-primary-custom" style="font-size: 5rem;"></i>
                    </div>
                    <h4>{{ auth()->user()->name }}</h4>
                    <p class="text-muted">Patient</p>
                    
                    @if(!auth()->user()->patient || !auth()->user()->patient->date_of_birth)
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> Profile incomplete
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Stats</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-primary-custom">{{ auth()->user()->patient->appointments->count() }}</h5>
                            <small class="text-muted">Total Appointments</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success">{{ auth()->user()->patient->prescriptions->count() }}</h5>
                            <small class="text-muted">Prescriptions</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-col col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Full Name</label>
                                <p class="fw-bold">{{ auth()->user()->name }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p>{{ auth()->user()->email }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Phone</label>
                                <p>{{ auth()->user()->phone ?: 'Not provided' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">CNIC</label>
                                <p>{{ auth()->user()->cnic ?: 'Not provided' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Date of Birth</label>
                                <p>
                                    @if(auth()->user()->patient && auth()->user()->patient->date_of_birth)
                                        {{ auth()->user()->patient->date_of_birth->format('M d, Y') }} 
                                        ({{ auth()->user()->patient->date_of_birth->age }} years old)
                                    @else
                                        Not provided
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Gender</label>
                                <p>{{ auth()->user()->patient && auth()->user()->patient->gender ? ucfirst(auth()->user()->patient->gender) : 'Not provided' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Blood Group</label>
                                <p>{{ auth()->user()->patient && auth()->user()->patient->blood_group ?: 'Not provided' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted">Emergency Contact</label>
                                <p>{{ auth()->user()->patient && auth()->user()->patient->emergency_contact ?: 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Address</label>
                        <p>{{ auth()->user()->address ?: 'Not provided' }}</p>
                    </div>
                    
                    @if(auth()->user()->patient && auth()->user()->patient->medical_history)
                        <div class="mb-3">
                            <label class="form-label text-muted">Medical History</label>
                            <p class="bg-light p-3 rounded">{{ auth()->user()->patient->medical_history }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection