@extends('layouts.dashboard')

@section('title', 'Add New Patient')

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
    <h1 class="h2">Add New Patient</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Patients
        </a>
    </div>
</div>

<form action="{{ route('admin.patients.store') }}" method="POST">
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
                    <h5 class="mb-0">Medical Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="blood_group" class="form-label">Blood Group</label>
                        <input type="text" class="form-control @error('blood_group') is-invalid @enderror"
                               id="blood_group" name="blood_group" value="{{ old('blood_group') }}" placeholder="A+, B-, O+">
                        @error('blood_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="emergency_contact" class="form-label">Emergency Contact</label>
                        <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror"
                               id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" placeholder="03XX-XXXXXXX">
                        @error('emergency_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="medical_history" class="form-label">Medical History</label>
                        <textarea class="form-control @error('medical_history') is-invalid @enderror"
                                  id="medical_history" name="medical_history" rows="4">{{ old('medical_history') }}</textarea>
                        @error('medical_history')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-person-plus"></i> Add Patient
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
