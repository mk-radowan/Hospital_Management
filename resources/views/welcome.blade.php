@extends('layouts.app')

@section('title', 'Welcome to hospitally')

@section('content')
    <div class="hero-section bg-primary-custom text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Hospitally</h1>
                    <p class="lead mb-4">Your trusted Hospital & Clinic Management System for Bangladesh. Book appointments,
                        manage medical records, and connect with healthcare professionals.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('patient.register') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-person-plus"></i> Register as Patient
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-light btn-lg dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('patient.login') }}">Patient Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('doctor.login') }}">Doctor Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.login') }}">Admin Login</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-hospital display-1" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Why Choose hospitally?</h2>
                <p class="lead text-muted">Designed specifically for Bangladeshi healthcare needs with local features and
                    bilingual support.</p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-calendar-check text-primary-custom display-4 mb-3"></i>
                        <h5 class="card-title">Easy Appointments</h5>
                        <p class="card-text">Book appointments with your preferred doctors. Real-time availability and
                            instant confirmations.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-file-medical text-primary-custom display-4 mb-3"></i>
                        <h5 class="card-title">Digital Prescriptions</h5>
                        <p class="card-text">Access your prescriptions digitally. Download and print whenever needed. No
                            more lost prescriptions.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-shield-check text-primary-custom display-4 mb-3"></i>
                        <h5 class="card-title">Secure & Private</h5>
                        <p class="card-text">Your medical data is encrypted and secure. HIPAA compliant with Bangladeshi
                            privacy standards.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 mb-4">
                <div class="card bg-light border-0">
                    <div class="card-body p-4">
                        <h5 class="text-primary-custom">For Patients</h5>
                        <ul class="list-unstyled mt-3">
                            <li><i class="bi bi-check-circle text-success me-2"></i> Register and manage your profile</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i> Book appointments online</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i> View medical history</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i> Download prescriptions</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i> Get appointment reminders</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card bg-light border-0">
                    <div class="card-body p-4">
                        <h5 class="text-primary-custom">For Doctors</h5>
                        <ul class="list-unstyled mt-3">
                            <li><i class="bi bi-check-circle text-success me-2"></i> Manage appointment schedules</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i> Access patient records</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i> Create digital prescriptions</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i> Track patient history</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i> Set availability schedule</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light py-5 mt-5">
        <div class="container text-center">
            <h3 class="mb-4">Ready to Get Started?</h3>
            <p class="lead mb-4">Join thousands of satisfied patients and healthcare providers across Bangladesh.</p>
            <a href="{{ route('patient.register') }}" class="btn btn-primary-custom btn-lg">
                <i class="bi bi-person-plus"></i> Register Now
            </a>
        </div>
    </div>
@endsection
