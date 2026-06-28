@extends('layouts.dashboard')

@section('title', 'Edit Profile')

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
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Profile</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('patient.profile.show') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Profile
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('patient.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                               placeholder="03XX-XXXXXXX">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                               id="date_of_birth" name="date_of_birth" 
                               value="{{ old('date_of_birth', auth()->user()->patient && auth()->user()->patient->date_of_birth ? auth()->user()->patient->date_of_birth->format('Y-m-d') : '') }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', auth()->user()->patient && auth()->user()->patient->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', auth()->user()->patient && auth()->user()->patient->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', auth()->user()->patient && auth()->user()->patient->gender) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="blood_group" class="form-label">Blood Group</label>
                        <select class="form-select @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group">
                            <option value="">Select Blood Group</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bloodGroup)
                                <option value="{{ $bloodGroup }}" {{ old('blood_group', auth()->user()->patient && auth()->user()->patient->blood_group) === $bloodGroup ? 'selected' : '' }}>
                                    {{ $bloodGroup }}
                                </option>
                            @endforeach
                        </select>
                        @error('blood_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="emergency_contact" class="form-label">Emergency Contact</label>
                        <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                               id="emergency_contact" name="emergency_contact" 
                               value="{{ old('emergency_contact', auth()->user()->patient && auth()->user()->patient->emergency_contact) }}"
                               placeholder="03XX-XXXXXXX">
                        @error('emergency_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address" rows="3"
                          placeholder="House/Flat No, Street, Area, City">{{ old('address', auth()->user()->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="medical_history" class="form-label">Medical History</label>
                <textarea class="form-control @error('medical_history') is-invalid @enderror" 
                          id="medical_history" name="medical_history" rows="4"
                          placeholder="Any chronic conditions, allergies, previous surgeries, medications, etc.">{{ old('medical_history', auth()->user()->patient && auth()->user()->patient->medical_history) }}</textarea>
                @error('medical_history')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('patient.profile.show') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-check-circle"></i> Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection