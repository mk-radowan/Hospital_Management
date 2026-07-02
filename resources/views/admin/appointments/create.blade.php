@extends('layouts.dashboard')

@section('title', 'Create Appointment')

@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create Appointment</h1>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.appointments.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="patient_id" class="form-label">Patient <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patient_id"
                            class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">Select patient</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user->name }} ({{ $patient->user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="doctor_id" class="form-label">Doctor <span class="text-danger">*</span></label>
                        <select name="doctor_id" id="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror"
                            required>
                            <option value="">Select doctor</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->user->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="appointment_date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="appointment_date" id="appointment_date"
                            class="form-control @error('appointment_date') is-invalid @enderror"
                            value="{{ old('appointment_date') }}" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="appointment_time" class="form-label">Time <span class="text-danger">*</span></label>
                        <input type="time" name="appointment_time" id="appointment_time"
                            class="form-control @error('appointment_time') is-invalid @enderror"
                            value="{{ old('appointment_time') }}" required>
                        @error('appointment_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="symptoms" class="form-label">Symptoms</label>
                        <textarea name="symptoms" id="symptoms" rows="4" class="form-control @error('symptoms') is-invalid @enderror"
                            placeholder="Describe symptoms (optional)">{{ old('symptoms') }}</textarea>
                        @error('symptoms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-calendar-plus"></i> Create Appointment
                    </button>
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
