@extends('layouts.dashboard')

@section('title', 'Create Prescription')

@section('sidebar')
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('doctor.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('doctor.appointments.index') }}">
            <i class="bi bi-calendar-check"></i> Appointments
        </a>
    </li>
</ul>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Prescription</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('doctor.appointments.show', $appointment) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Appointment
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Prescription Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('doctor.prescriptions.store', $appointment) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" 
                                  id="diagnosis" name="diagnosis" rows="3" required
                                  placeholder="Patient's diagnosis...">{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Medications</label>
                        <div id="medications-container">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="medications[]" 
                                       placeholder="Medicine name, dosage, frequency">
                                <button type="button" class="btn btn-outline-danger remove-medication" disabled>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-medication">
                            <i class="bi bi-plus"></i> Add Medication
                        </button>
                    </div>
                    
                    <div class="mb-3">
                        <label for="instructions" class="form-label">Instructions</label>
                        <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                  id="instructions" name="instructions" rows="4"
                                  placeholder="Additional instructions for the patient...">{{ old('instructions') }}</textarea>
                        @error('instructions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="prescription_file" class="form-label">Upload Prescription File (Optional)</label>
                        <input type="file" class="form-control @error('prescription_file') is-invalid @enderror" 
                               id="prescription_file" name="prescription_file" accept=".pdf">
                        <div class="form-text">Only PDF files are allowed. Max size: 2MB</div>
                        @error('prescription_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('doctor.appointments.show', $appointment) }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-file-medical"></i> Create Prescription
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Patient Information</h5>
            </div>
            <div class="card-body">
                <h6>{{ $appointment->patient->user->name }}</h6>
                @if($appointment->patient->gender)
                    <p class="mb-1"><strong>Gender:</strong> {{ ucfirst($appointment->patient->gender) }}</p>
                @endif
                @if($appointment->patient->date_of_birth)
                    <p class="mb-1"><strong>Age:</strong> {{ $appointment->patient->date_of_birth->age }} years</p>
                @endif
                @if($appointment->patient->blood_group)
                    <p class="mb-1"><strong>Blood Group:</strong> {{ $appointment->patient->blood_group }}</p>
                @endif
                
                @if($appointment->symptoms)
                    <div class="mt-3">
                        <h6>Symptoms:</h6>
                        <p class="bg-light p-2 rounded small">{{ $appointment->symptoms }}</p>
                    </div>
                @endif
                
                @if($appointment->patient->medical_history)
                    <div class="mt-3">
                        <h6>Medical History:</h6>
                        <p class="bg-light p-2 rounded small">{{ $appointment->patient->medical_history }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let medicationCount = 1;
    
    document.getElementById('add-medication').addEventListener('click', function() {
        const container = document.getElementById('medications-container');
        const newMedication = document.createElement('div');
        newMedication.className = 'input-group mb-2';
        newMedication.innerHTML = `
            <input type="text" class="form-control" name="medications[]" 
                   placeholder="Medicine name, dosage, frequency">
            <button type="button" class="btn btn-outline-danger remove-medication">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.appendChild(newMedication);
        medicationCount++;
        updateRemoveButtons();
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-medication') || e.target.closest('.remove-medication')) {
            e.preventDefault();
            const medicationDiv = e.target.closest('.input-group');
            medicationDiv.remove();
            medicationCount--;
            updateRemoveButtons();
        }
    });
    
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-medication');
        removeButtons.forEach(button => {
            button.disabled = removeButtons.length <= 1;
        });
    }
});
</script>
@endpush