<?php
// resources/views/patient/appointments/create.blade.php (FIXED VERSION)
?>
@extends('layouts.dashboard')

@section('title', 'Book Appointment - LaraMediCare')

@section('sidebar')
<nav class="nav nav-pills flex-column">
    <a class="nav-link" href="{{ route('patient.dashboard') }}">
        <i class="bi bi-house-door"></i> Dashboard
    </a>
    <a class="nav-link" href="{{ route('patient.profile.show') }}">
        <i class="bi bi-person"></i> My Profile
    </a>
    <a class="nav-link" href="{{ route('patient.appointments.index') }}">
        <i class="bi bi-calendar-check"></i> My Appointments
    </a>
    <a class="nav-link active" href="{{ route('patient.appointments.create') }}">
        <i class="bi bi-plus-circle"></i> Book Appointment
    </a>
    <a class="nav-link" href="{{ route('patient.prescriptions.index') }}">
        <i class="bi bi-file-medical"></i> My Prescriptions
    </a>
</nav>
@endsection

@push('styles')
<style>
    .doctor-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        cursor: pointer;
    }
    .doctor-card:hover {
        border-color: #2c5aa0;
        box-shadow: 0 4px 8px rgba(44, 90, 160, 0.15);
    }
    .doctor-card.selected {
        border-color: #2c5aa0;
        background-color: #f8f9ff;
    }
    
    .step-card {
        transition: all 0.3s ease;
    }
    
    /* FIXED: Properly hide steps */
    .step-card.step-hidden {
        display: none !important;
    }
    
    .step-indicator {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        font-weight: bold;
        font-size: 14px;
    }
    
    .step-indicator.active {
        background-color: #2c5aa0;
        color: white;
    }
    
    .step-indicator.completed {
        background-color: #198754;
        color: white;
    }
    
    .step-indicator.pending {
        background-color: #e9ecef;
        color: #6c757d;
    }
    
    .sticky-sidebar {
        position: sticky;
        top: 20px;
        z-index: 10;
    }
    
    .form-navigation {
        position: sticky;
        bottom: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        z-index: 100;
    }
    
    @media (max-width: 768px) {
        .sticky-sidebar {
            position: relative;
            top: auto;
        }
    }
    
    .doctor-list-container {
        max-height: 400px;
        overflow-y: auto;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    .doctor-compact-card {
        padding: 12px;
        border-bottom: 1px solid #f8f9fa;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .doctor-compact-card:last-child {
        border-bottom: none;
    }
    
    .doctor-compact-card:hover {
        background-color: #f8f9fa;
    }
    
    .doctor-compact-card.selected {
        background-color: #e7f3ff;
        border-left: 4px solid #2c5aa0;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Book New Appointment</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('patient.appointments.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Appointments
        </a>
    </div>
</div>

<!-- Progress Indicator -->
<div class="card mb-4">
    <div class="card-body py-3">
        <div class="row text-center">
            <div class="col-4">
                <div class="step-indicator active" id="step1-indicator">1</div>
                <div class="mt-2 small">Select Doctor</div>
            </div>
            <div class="col-4">
                <div class="step-indicator pending" id="step2-indicator">2</div>
                <div class="mt-2 small">Date & Time</div>
            </div>
            <div class="col-4">
                <div class="step-indicator pending" id="step3-indicator">3</div>
                <div class="mt-2 small">Symptoms</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('patient.appointments.store') }}" id="appointmentForm">
            @csrf
            
            <!-- Step 1: Select Doctor -->
            <div class="card mb-4 step-card" id="step1">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <span class="step-indicator active me-2">1</span>
                        Select Doctor
                    </h5>
                    <small class="text-muted" id="selected-doctor-name"></small>
                </div>
                <div class="card-body">
                    @if($doctors->count() > 0)
                        <div class="doctor-list-container">
                            @foreach($doctors as $doctor)
                                <div class="doctor-compact-card" onclick="selectDoctor({{ $doctor->id }})">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="radio" name="doctor_id" 
                                               id="doctor_{{ $doctor->id }}" value="{{ $doctor->id }}"
                                               {{ old('doctor_id') == $doctor->id ? 'checked' : '' }}
                                               data-fee="{{ $doctor->consultation_fee }}"
                                               data-name="{{ $doctor->user->name }}">
                                        <label class="form-check-label w-100" for="doctor_{{ $doctor->id }}">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h6 class="mb-1">{{ $doctor->user->name }}</h6>
                                                    <p class="text-muted mb-1 small">{{ $doctor->specialization }}</p>
                                                    <small class="text-info">{{ $doctor->qualification }}</small>
                                                    <br>
                                                    <small class="text-success">
                                                        <i class="bi bi-briefcase"></i> {{ $doctor->experience_years }} years
                                                    </small>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <strong class="text-primary-custom">
                                                        ₨ {{ number_format($doctor->consultation_fee) }}
                                                    </strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ implode(', ', array_map('ucfirst', array_slice($doctor->available_days ?? [], 0, 2))) }}
                                                        @if(count($doctor->available_days ?? []) > 2)
                                                            +{{ count($doctor->available_days) - 2 }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('doctor_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-person-x text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-3 text-muted">No doctors available at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Step 2: Select Date & Time -->
            <div class="card mb-4 step-card step-hidden" id="step2">
                <div class="card-header">
                    <h5 class="mb-0">
                        <span class="step-indicator pending me-2">2</span>
                        Select Date & Time
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="appointment_date" class="form-label">Appointment Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" 
                                   id="appointment_date" name="appointment_date" 
                                   value="{{ old('appointment_date') }}" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   max="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                            @error('appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="appointment_time" class="form-label">Appointment Time <span class="text-danger">*</span></label>
                            <select class="form-select @error('appointment_time') is-invalid @enderror" 
                                    id="appointment_time" name="appointment_time" required>
                                <option value="">Select date first...</option>
                            </select>
                            @error('appointment_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Symptoms -->
            <div class="card mb-4 step-card step-hidden" id="step3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <span class="step-indicator pending me-2">3</span>
                        Symptoms & Notes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="symptoms" class="form-label">Symptoms/Reason for Visit</label>
                        <textarea class="form-control @error('symptoms') is-invalid @enderror" 
                                  id="symptoms" name="symptoms" rows="4" 
                                  placeholder="Describe your symptoms or reason for consultation...">{{ old('symptoms') }}</textarea>
                        @error('symptoms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Optional: Provide details to help the doctor prepare for your consultation.</small>
                    </div>
                </div>
            </div>

            <!-- Sticky Navigation -->
            <div class="form-navigation p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('patient.appointments.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <div>
                        <button type="button" class="btn btn-outline-primary me-2" id="prevBtn" style="display:none;" onclick="changeStep(-1)">
                            <i class="bi bi-arrow-left"></i> Previous
                        </button>
                        <button type="button" class="btn btn-primary-custom" id="nextBtn" onclick="changeStep(1)" disabled>
                            Next <i class="bi bi-arrow-right"></i>
                        </button>
                        <button type="submit" class="btn btn-success" id="submitBtn" style="display:none;">
                            <i class="bi bi-calendar-check"></i> Book Appointment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Selected Doctor</h5>
                </div>
                <div class="card-body" id="doctor-info">
                    <p class="text-muted">Select a doctor to view details</p>
                </div>
            </div>

            <div class="card mb-3" id="appointment-summary" style="display:none;">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Appointment Summary</h5>
                </div>
                <div class="card-body" id="summary-content">
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-list-check"></i> Guidelines</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Arrive 15 minutes early</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Bring CNIC and medical history</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Cancel up to 2 hours before</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Payment due at consultation</li>
                        <li class="mb-0"><i class="bi bi-check-circle text-success me-2"></i> Prescription available after visit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const doctorDetailsRouteTemplate = "{{ route('ajax.doctors.show', ['doctorId' => '__DOCTOR_ID__']) }}";
    const doctorSlotsRouteTemplate = "{{ route('ajax.doctors.slots', ['doctorId' => '__DOCTOR_ID__']) }}";

document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 3;
    
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    const dateInput = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('appointment_time');
    const doctorInfo = document.getElementById('doctor-info');
    const appointmentSummary = document.getElementById('appointment-summary');
    const summaryContent = document.getElementById('summary-content');

    // Get CSRF token
    function getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
               document.querySelector('input[name="_token"]')?.value || '';
    }

    // FIXED: Update step indicators and navigation with proper show/hide
    function updateStepUI() {
        console.log('Updating step UI. Current step:', currentStep);
        
        // Hide all steps first
        for (let i = 1; i <= totalSteps; i++) {
            const stepCard = document.getElementById(`step${i}`);
            const indicator = document.getElementById(`step${i}-indicator`);
            
            if (i === currentStep) {
                // Show current step
                stepCard.classList.remove('step-hidden');
                indicator.className = 'step-indicator active';
            } else if (i < currentStep) {
                // Hide completed steps but mark as completed
                stepCard.classList.add('step-hidden');
                indicator.className = 'step-indicator completed';
            } else {
                // Hide pending steps
                stepCard.classList.add('step-hidden');
                indicator.className = 'step-indicator pending';
            }
        }
        
        // Update navigation buttons
        prevBtn.style.display = currentStep > 1 ? 'inline-block' : 'none';
        
        if (currentStep === totalSteps) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            submitBtn.style.display = 'none';
        }
        
        // Update next button state
        updateNextButtonState();
        
        // Enable time select if we're on step 2 and have a doctor selected
        if (currentStep === 2) {
            const selectedDoctor = document.querySelector('input[name="doctor_id"]:checked');
            if (selectedDoctor && timeSelect.disabled) {
                timeSelect.disabled = false;
            }
        }
        
        console.log('Step UI updated. Visible step:', currentStep);
    }

    // Update next button state based on current step validation
    function updateNextButtonState() {
        let isValid = false;
        
        switch(currentStep) {
            case 1:
                isValid = document.querySelector('input[name="doctor_id"]:checked') !== null;
                break;
            case 2:
                isValid = dateInput.value && timeSelect.value;
                break;
            case 3:
                isValid = true; // Symptoms are optional
                break;
        }
        
        nextBtn.disabled = !isValid;
        if (currentStep === totalSteps) {
            submitBtn.disabled = !isValid;
        }
        
        console.log('Next button state updated. Step:', currentStep, 'Valid:', isValid);
    }

    // FIXED: Change step function with better logging
    window.changeStep = function(direction) {
        console.log('changeStep called. Direction:', direction, 'Current:', currentStep);
        
        const newStep = currentStep + direction;
        
        if (newStep >= 1 && newStep <= totalSteps) {
            // Validate current step before moving
            if (direction > 0) { // Moving forward
                if (currentStep === 1 && !document.querySelector('input[name="doctor_id"]:checked')) {
                    alert('Please select a doctor first');
                    return;
                }
                if (currentStep === 2 && (!dateInput.value || !timeSelect.value)) {
                    alert('Please select both date and time');
                    return;
                }
            }
            
            currentStep = newStep;
            console.log('Moving to step:', currentStep);
            updateStepUI();
            
            // Scroll to current step
            const stepElement = document.getElementById(`step${currentStep}`);
            if (stepElement) {
                stepElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            
            if (currentStep === 3) {
                updateAppointmentSummary();
            }
        }
    };

    // Function to select doctor
    window.selectDoctor = function(doctorId) {
        console.log('selectDoctor called with:', doctorId);
        
        // Clear all selections
        document.querySelectorAll('.doctor-compact-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Select the clicked doctor
        const selectedCard = document.querySelector(`#doctor_${doctorId}`).closest('.doctor-compact-card');
        selectedCard.classList.add('selected');
        
        // Check the radio button
        const radioButton = document.querySelector(`#doctor_${doctorId}`);
        radioButton.checked = true;
        console.log('Radio button checked:', radioButton.checked);
        
        // Update selected doctor name
        const doctorName = radioButton.getAttribute('data-name');
        document.getElementById('selected-doctor-name').textContent = doctorName;
        
        // Load doctor details
        loadDoctorDetails(doctorId);
        
        // Reset subsequent steps
        timeSelect.innerHTML = '<option value="">Select date first...</option>';
        timeSelect.disabled = true;
        
        // Update next button state
        updateNextButtonState();
    };

    // Function to load doctor details
    function loadDoctorDetails(doctorId) {
        if (!doctorId) {
            doctorInfo.innerHTML = '<p class="text-muted">Select a doctor to view details</p>';
            return;
        }

        doctorInfo.innerHTML = '<p class="text-muted"><i class="bi bi-hourglass-split"></i> Loading...</p>';

        const csrfToken = getCSRFToken();
        
        const doctorDetailsUrl = doctorDetailsRouteTemplate.replace('__DOCTOR_ID__', doctorId);

        fetch(doctorDetailsUrl, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                let availableDays = 'N/A';
                if (Array.isArray(data.available_days) && data.available_days.length > 0) {
                    availableDays = data.available_days.map(day => 
                        day.charAt(0).toUpperCase() + day.slice(1).toLowerCase()
                    ).join(', ');
                }
                
                doctorInfo.innerHTML = `
                    <div class="text-center mb-3">
                        <i class="bi bi-person-circle text-primary-custom" style="font-size: 2.5rem;"></i>
                    </div>
                    <h6 class="text-center">${data.name}</h6>
                    <hr>
                    <p class="mb-2"><strong><i class="bi bi-stethoscope"></i> Specialization:</strong><br><small>${data.specialization}</small></p>
                    <p class="mb-2"><strong><i class="bi bi-award"></i> Qualification:</strong><br><small>${data.qualification}</small></p>
                    <p class="mb-2"><strong><i class="bi bi-currency-exchange"></i> Fee:</strong><br><span class="text-primary-custom fw-bold">₨ ${parseFloat(data.consultation_fee).toLocaleString()}</span></p>
                    <p class="mb-0"><strong><i class="bi bi-calendar-week"></i> Available:</strong><br><small>${availableDays}</small></p>
                `;
            } else {
                throw new Error(data.error || 'Unknown error occurred');
            }
        })
        .catch(error => {
            doctorInfo.innerHTML = `
                <div class="text-center text-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <p class="mt-2 mb-0 small">Error loading details</p>
                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="loadDoctorDetails(${doctorId})">Retry</button>
                </div>
            `;
        });
    }

    // Handle date selection
    dateInput.addEventListener('change', function() {
        const selectedDoctorInput = document.querySelector('input[name="doctor_id"]:checked');
        const doctorId = selectedDoctorInput ? selectedDoctorInput.value : null;
        const date = this.value;
        
        console.log('Date changed:', date, 'Doctor:', doctorId);
        
        if (doctorId && date) {
            timeSelect.innerHTML = '<option value="">Loading...</option>';
            timeSelect.disabled = true;
            
            const csrfToken = getCSRFToken();
            
            const doctorSlotsUrl = doctorSlotsRouteTemplate.replace('__DOCTOR_ID__', doctorId) + `?date=${date}`;

            fetch(doctorSlotsUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                timeSelect.innerHTML = '<option value="">Select time...</option>';
                
                if (data.success && data.slots && data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        timeSelect.innerHTML += `<option value="${slot.time}">${slot.display}</option>`;
                    });
                    timeSelect.disabled = false;
                    console.log('Time slots loaded:', data.slots.length);
                } else {
                    const message = data.message || 'No available slots for this date';
                    timeSelect.innerHTML = `<option value="">${message}</option>`;
                    console.log('No slots available:', message);
                }
                updateNextButtonState();
            })
            .catch(error => {
                console.error('Error loading time slots:', error);
                timeSelect.innerHTML = `<option value="">Error loading slots</option>`;
                updateNextButtonState();
            });
        }
        updateNextButtonState();
    });

    // Handle time selection
    timeSelect.addEventListener('change', function() {
        console.log('Time selected:', this.value);
        updateNextButtonState();
    });

    // Update appointment summary
    function updateAppointmentSummary() {
        const selectedDoctor = document.querySelector('input[name="doctor_id"]:checked');
        const date = dateInput.value;
        const time = timeSelect.value;
        
        if (selectedDoctor && date && time) {
            const doctorName = selectedDoctor.getAttribute('data-name');
            const fee = selectedDoctor.getAttribute('data-fee');
            
            const formattedDate = new Date(date).toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            summaryContent.innerHTML = `
                <p class="mb-2"><strong>Doctor:</strong><br>${doctorName}</p>
                <p class="mb-2"><strong>Date:</strong><br>${formattedDate}</p>
                <p class="mb-2"><strong>Time:</strong><br>${time}</p>
                <p class="mb-0"><strong>Consultation Fee:</strong><br><span class="text-success fw-bold">₨ ${parseFloat(fee).toLocaleString()}</span></p>
            `;
            
            appointmentSummary.style.display = 'block';
        }
    }

    // FIXED: Initialize - Make sure only step 1 is visible
    function initializeSteps() {
        console.log('Initializing steps...');
        currentStep = 1;
        
        // Ensure step visibility
        document.getElementById('step1').classList.remove('step-hidden');
        document.getElementById('step2').classList.add('step-hidden');
        document.getElementById('step3').classList.add('step-hidden');
        
        updateStepUI();
        console.log('Steps initialized. Current step:', currentStep);
    }

    // Initialize
    initializeSteps();
    
    // Initialize with pre-selected doctor (if any)
    const selectedDoctor = document.querySelector('input[name="doctor_id"]:checked');
    if (selectedDoctor) {
        selectDoctor(selectedDoctor.value);
    }
    
    // Add form submission handler
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        console.log('Form submitting...');
        // Let the form submit naturally
    });
});
</script>
@endpush