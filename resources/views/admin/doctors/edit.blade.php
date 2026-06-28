@extends('layouts.dashboard')

@section('title', 'Edit Doctor - ' . $doctor->user->name)

@push('styles')
<style>
    .form-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .form-section h5 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-cancel {
        background: #f8fafc;
        border: 2px solid #e5e7eb;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        color: #374151;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
        color: #374151;
        text-decoration: none;
    }

    .required {
        color: #e53e3e;
    }

    .form-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .status-toggle {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .alert {
        border-radius: 8px;
        border: none;
        padding: 1rem 1.5rem;
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1.5rem;
        }

        .btn-save, .btn-cancel {
            width: 100%;
            margin-bottom: 0.5rem;
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
        <li class="breadcrumb-item"><a href="{{ route('admin.doctors.show', $doctor) }}">{{ $doctor->user->name }}</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 text-primary">Edit Doctor</h1>
    <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Profile
    </a>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Personal Information -->
        <div class="col-lg-6">
            <div class="form-section">
                <h5>
                    <i class="bi bi-person text-primary"></i>
                    Personal Information
                </h5>

                <div class="form-group">
                    <label for="name" class="form-label">
                        Full Name <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $doctor->user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        Email Address <span class="required">*</span>
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $doctor->user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $doctor->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $doctor->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $doctor->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" name="date_of_birth" 
                                   value="{{ old('date_of_birth', $doctor->date_of_birth ? $doctor->date_of_birth->format('Y-m-d') : '') }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="col-lg-6">
            <div class="form-section">
                <h5>
                    <i class="bi bi-briefcase text-success"></i>
                    Professional Information
                </h5>

                <div class="form-group">
                    <label for="specialization" class="form-label">
                        Specialization <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control @error('specialization') is-invalid @enderror" 
                           id="specialization" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" required>
                    @error('specialization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="qualification" class="form-label">
                        Qualification <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control @error('qualification') is-invalid @enderror" 
                           id="qualification" name="qualification" value="{{ old('qualification', $doctor->qualification) }}" required>
                    <div class="form-text">e.g., MBBS, MD, MS, etc.</div>
                    @error('qualification')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="experience_years" class="form-label">
                                Experience (Years) <span class="required">*</span>
                            </label>
                            <input type="number" class="form-control @error('experience_years') is-invalid @enderror" 
                                   id="experience_years" name="experience_years" 
                                   value="{{ old('experience_years', $doctor->experience_years) }}" 
                                   min="0" max="50" required>
                            @error('experience_years')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="consultation_fee" class="form-label">
                                Consultation Fee (₨) <span class="required">*</span>
                            </label>
                            <input type="number" class="form-control @error('consultation_fee') is-invalid @enderror" 
                                   id="consultation_fee" name="consultation_fee" 
                                   value="{{ old('consultation_fee', $doctor->consultation_fee) }}" 
                                   min="0" step="0.01" required>
                            @error('consultation_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="license_number" class="form-label">Medical License Number</label>
                    <input type="text" class="form-control @error('license_number') is-invalid @enderror" 
                           id="license_number" name="license_number" value="{{ old('license_number', $doctor->license_number) }}">
                    @error('license_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div class="col-12">
            <div class="form-section">
                <h5>
                    <i class="bi bi-geo-alt text-warning"></i>
                    Address Information
                </h5>

                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3">{{ old('address', $doctor->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city', $doctor->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="state" class="form-label">State/Province</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                   id="state" name="state" value="{{ old('state', $doctor->state) }}">
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bio/Description -->
        <div class="col-12">
            <div class="form-section">
                <h5>
                    <i class="bi bi-file-text text-info"></i>
                    Biography & Additional Information
                </h5>

                <div class="form-group">
                    <label for="bio" class="form-label">Biography</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" 
                              id="bio" name="bio" rows="4" 
                              placeholder="Enter doctor's biography, specialties, achievements, etc.">{{ old('bio', $doctor->bio) }}</textarea>
                    <div class="form-text">Brief description about the doctor's background and expertise</div>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Status & Settings -->
        <div class="col-12">
            <div class="form-section">
                <h5>
                    <i class="bi bi-gear text-secondary"></i>
                    Account Settings
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="status-toggle">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $doctor->user->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Account Active</strong>
                                    <div class="form-text">Allow doctor to login and access the system</div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="status-toggle">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_available" name="is_available" 
                                       value="1" {{ old('is_available', $doctor->is_available) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_available">
                                    <strong>Available for Appointments</strong>
                                    <div class="form-text">Allow patients to book appointments</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Reset Option -->
                <div class="form-group mt-3">
                    <label for="password" class="form-label">New Password (Optional)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" placeholder="Leave blank to keep current password">
                    <div class="form-text">Only fill this field if you want to change the doctor's password</div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                           placeholder="Confirm new password">
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-section">
        <div class="d-flex gap-3 justify-content-end flex-wrap">
            <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-cancel">
                <i class="bi bi-x-circle me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-save">
                <i class="bi bi-check-circle me-1"></i> Save Changes
            </button>
        </div>
    </div>
</form>

<!-- Delete Doctor Section -->
<div class="form-section border-danger">
    <h5 class="text-danger">
        <i class="bi bi-exclamation-triangle"></i>
        Danger Zone
    </h5>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <strong>Delete Doctor Account</strong>
            <p class="text-muted mb-0">Permanently delete this doctor account and all associated data. This action cannot be undone.</p>
        </div>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="bi bi-trash"></i> Delete Doctor
        </button>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $doctor->user->name }}</strong>?</p>
                <p class="text-danger small mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    This will permanently delete the doctor account, all appointments, and related data. This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Delete Doctor
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Form validation and enhancements
    document.addEventListener('DOMContentLoaded', function() {
        // Phone number formatting
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    if (value.length <= 4) {
                        value = value;
                    } else if (value.length <= 7) {
                        value = value.slice(0, 4) + '-' + value.slice(4);
                    } else {
                        value = value.slice(0, 4) + '-' + value.slice(4, 7) + '-' + value.slice(7, 11);
                    }
                }
                e.target.value = value;
            });
        }

        // Experience validation
        const experienceInput = document.getElementById('experience_years');
        if (experienceInput) {
            experienceInput.addEventListener('change', function(e) {
                const value = parseInt(e.target.value);
                if (value < 0) e.target.value = 0;
                if (value > 50) e.target.value = 50;
            });
        }

        // Fee validation
        const feeInput = document.getElementById('consultation_fee');
        if (feeInput) {
            feeInput.addEventListener('change', function(e) {
                const value = parseFloat(e.target.value);
                if (value < 0) e.target.value = 0;
            });
        }

        // Password confirmation validation
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        function validatePasswords() {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Passwords do not match');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
        }

        if (password && passwordConfirmation) {
            password.addEventListener('input', validatePasswords);
            passwordConfirmation.addEventListener('input', validatePasswords);
        }
    });
</script>
@endpush
@endsection