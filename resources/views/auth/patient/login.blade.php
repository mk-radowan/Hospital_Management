@extends('layouts.app')

@section('title', 'Patient Login - LaraMediCare')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary-custom text-white">
                    <h4 class="mb-0 text-center">
                        <i class="bi bi-person-circle"></i> Patient Login
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('patient.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-custom btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-2">Don't have an account?</p>
                        <a href="{{ route('patient.register') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus"></i> Register as Patient
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Are you a doctor or admin? 
                            <a href="{{ route('doctor.login') }}">Doctor Login</a> | 
                            <a href="{{ route('admin.login') }}">Admin Login</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection