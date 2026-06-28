@extends('layouts.dashboard')

@section('title', 'Add New Doctor')

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
    <h1 class="h2">Add New Doctor</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Doctors
        </a>
    </div>
</div>

<form action="{{ route('admin.doctors.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" placeholder="03XX-XXXXXXX">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="cnic" class="form-label">CNIC</label>
                        <input type="text" class="form-control @error('cnic') is-invalid @enderror" 
                               id="cnic" name="cnic" value="{{ old('cnic') }}" placeholder="XXXXX-XXXXXXX-X">
                        @error('cnic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Professional Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="specialization" class="form-label">Specialization <span class="text-danger">*</span></label>
                        <select class="form-select @error('specialization') is-invalid @enderror" 
                                id="specialization" name="specialization" required>
                            <option value="">Select Specialization</option>
                            @foreach(['General Physician', 'Cardiologist', 'Dermatologist', 'ENT Specialist', 'Gynecologist', 'Neurologist', 'Orthopedic Surgeon', 'Pediatrician', 'Psychiatrist', 'Urologist'] as $spec)
                                <option value="{{ $spec }}" {{ old('specialization') === $spec ? 'selected' : '' }}>{{ $spec }}</option>
                            @endforeach
                        </select>
                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="qualification" class="form-label">Qualification <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('qualification') is-invalid @enderror" 
                               id="qualification" name="qualification" value="{{ old('qualification') }}" 
                               placeholder="MBBS, FCPS, etc." required>
                        @error('qualification')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="experience_years" class="form-label">Experience (Years) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('experience_years') is-invalid @enderror" 
                               id="experience_years" name="experience_years" value="{{ old('experience_years') }}" 
                               min="0" required>
                        @error('experience_years')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="consultation_fee" class="form-label">Consultation Fee (PKR) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('consultation_fee') is-invalid @enderror" 
                               id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') }}" 
                               min="0" step="0.01" required>
                        @error('consultation_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="license_number" class="form-label">License Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('license_number') is-invalid @enderror" 
                               id="license_number" name="license_number" value="{{ old('license_number') }}" required>
                        @error('license_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Available Days <span class="text-danger">*</span></label>
                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <div class="form-check">
                                <input class="form-check-input @error('available_days') is-invalid @enderror" 
                                       type="checkbox" name="available_days[]" value="{{ $day }}" 
                                       id="{{ $day }}" {{ in_array($day, old('available_days', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $day }}">
                                    {{ ucfirst($day) }}
                                </label>
                            </div>
                        @endforeach
                        @error('available_days')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="available_time_start" class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('available_time_start') is-invalid @enderror" 
                                       id="available_time_start" name="available_time_start" 
                                       value="{{ old('available_time_start', '09:00') }}" required>
                                @error('available_time_start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="available_time_end" class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('available_time_end') is-invalid @enderror" 
                                       id="available_time_end" name="available_time_end" 
                                       value="{{ old('available_time_end', '17:00') }}" required>
                                @error('available_time_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-12">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-person-plus"></i> Add Doctor
                </button>
            </div>
        </div>
    </div>
</form>
@endsection