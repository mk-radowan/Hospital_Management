@extends('layouts.dashboard')

@section('title', 'My Prescriptions')

@push('styles')
<style>
    /* Animation Keyframes */
    @keyframes cardFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }

    @keyframes shimmer {
        0% { background-position: -200px 0; }
        100% { background-position: calc(200px + 100%) 0; }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    @keyframes slideIn {
        from { transform: translateX(-20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* Main Layout */
    .main-content {
        margin-left: var(--sidebar-width, 280px);
        min-height: calc(100vh - 76px);
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        width: calc(100% - var(--sidebar-width, 280px)) !important;
        overflow-x: auto;
    }

    .content-wrapper {
        background: transparent;
        padding: 0;
        box-shadow: none;
        margin: 0;
        width: 100% !important;
        box-sizing: border-box;
    }

    /* Header with Blue Theme */
    .prescriptions-header {
        background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(44, 90, 160, 0.25);
        position: relative;
        overflow: hidden;
    }

    .prescriptions-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: cardFloat 6s ease-in-out infinite;
    }

    .prescriptions-header h1 {
        font-size: 2.2rem;
        font-weight: 600;
        margin: 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        position: relative;
        z-index: 2;
    }

    .prescriptions-stats {
        display: flex;
        gap: 2rem;
        margin-top: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.15);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Container Setup */
    .prescriptions-container {
        width: 100%;
        max-width: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .prescriptions-row {
        margin: 0 -15px !important;
        width: calc(100% + 30px) !important;
    }

    .prescription-col {
        padding: 0 15px !important;
        margin-bottom: 2rem;
    }

    /* Enhanced Prescription Cards */
    .prescription-card {
        background: white;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        position: relative;
        animation: slideIn 0.6s ease-out;
        width: 100% !important;
        min-height: 400px;
    }

    .prescription-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(44, 90, 160, 0.15);
    }

    .prescription-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #2c5aa0, #1e3d72, #4a90d9);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    /* Header Design */
    .prescription-header {
        background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
        color: white;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        border-radius: 15px 15px 0 0;
    }

    .prescription-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: cardFloat 8s ease-in-out infinite;
    }

    .prescription-date {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .download-btn {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        z-index: 3;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .download-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: white;
    }

    /* Doctor Info */
    .doctor-info {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1.5rem;
        border-left: 4px solid #2c5aa0;
        position: relative;
        overflow: hidden;
    }

    .doctor-info::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 60px;
        height: 60px;
        background: rgba(44, 90, 160, 0.08);
        border-radius: 50%;
        animation: pulse 3s ease-in-out infinite;
    }

    .doctor-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin-right: 1rem;
        box-shadow: 0 4px 15px rgba(44, 90, 160, 0.25);
    }

    .doctor-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 0.3rem 0;
        display: flex;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .doctor-specialization {
        font-size: 0.9rem;
        color: #2c5aa0;
        margin: 0;
        font-weight: 500;
        position: relative;
        z-index: 2;
    }

    /* Content Sections */
    .prescription-content {
        padding: 0 1.5rem 1.5rem;
        width: 100%;
        box-sizing: border-box;
    }

    .prescription-section {
        margin-bottom: 1.5rem;
        padding: 1.2rem;
        background: rgba(44, 90, 160, 0.03);
        border-radius: 10px;
        border: 1px solid rgba(44, 90, 160, 0.1);
        transition: all 0.3s ease;
    }

    .prescription-section:hover {
        background: rgba(44, 90, 160, 0.05);
        transform: translateX(3px);
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .section-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }

    .diagnosis-icon { background: linear-gradient(135deg, #dc3545 0%, #fd7e8f 100%); }
    .medication-icon { background: linear-gradient(135deg, #28a745 0%, #71dd8a 100%); }
    .instruction-icon { background: linear-gradient(135deg, #2c5aa0 0%, #4a90d9 100%); }

    .section-content {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #4a5568;
        padding-left: 2.5rem;
    }

    /* Medication List */
    .medication-list {
        list-style: none;
        padding: 0;
        margin: 0;
        padding-left: 2.5rem;
    }

    .medication-item {
        background: white;
        padding: 1rem 1.2rem;
        margin-bottom: 0.8rem;
        border-radius: 8px;
        border-left: 3px solid #28a745;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        position: relative;
    }

    .medication-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-left-color: #20c997;
    }

    .medication-item::before {
        content: '💊';
        position: absolute;
        left: -1px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1rem;
        background: white;
        padding: 0.1rem;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .medication-name {
        font-weight: 600;
        color: #2d3748;
        margin-left: 1.5rem;
        font-size: 0.95rem;
    }

    .more-medications {
        text-align: center;
        padding: 1rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 8px;
        margin-left: 2.5rem;
        border: 2px dashed #dee2e6;
        color: #6c757d;
        font-style: italic;
    }

    /* Footer */
    .card-footer {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        border-top: 1px solid rgba(44, 90, 160, 0.1);
        padding: 1.5rem !important;
    }

    .appointment-link {
        background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(44, 90, 160, 0.25);
    }

    .appointment-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 90, 160, 0.35);
        color: white;
        text-decoration: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        color: #2c5aa0;
        opacity: 0.7;
    }

    .empty-state h4 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .empty-state p {
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(44, 90, 160, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 90, 160, 0.4);
        background: linear-gradient(135deg, #1e3d72 0%, #2c5aa0 100%);
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
        padding: 2rem;
    }

    .pagination .page-link {
        border: none;
        color: #2c5aa0;
        background: transparent;
        padding: 0.8rem 1.2rem;
        margin: 0 0.2rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(44, 90, 160, 0.25);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #2c5aa0 0%, #1e3d72 100%);
        border-color: transparent;
        box-shadow: 0 4px 15px rgba(44, 90, 160, 0.25);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 1rem;
        }

        .prescriptions-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .prescriptions-header h1 {
            font-size: 1.8rem;
        }

        .prescriptions-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .prescription-col {
            padding: 0 10px !important;
        }
        
        .prescription-card {
            margin-bottom: 1.5rem;
            min-height: 350px;
        }
        
        .prescription-header {
            padding: 1.2rem;
        }
        
        .doctor-info {
            padding: 1.2rem;
            margin: 1rem;
        }
        
        .prescription-content {
            padding: 0 1rem 1rem;
        }

        .section-content,
        .medication-list {
            padding-left: 1.5rem;
        }
    }

    /* Badge Styling */
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }

    /* Loading Animation */
    .prescription-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="prescriptions-header">
    <h1>
        <i class="bi bi-file-medical me-3"></i>
        My Prescriptions
    </h1>
    <div class="prescriptions-stats">
        <div class="stat-item">
            <p class="stat-number">{{ $prescriptions->count() }}</p>
            <p class="stat-label">Total Prescriptions</p>
        </div>
        <div class="stat-item">
            <p class="stat-number">{{ $prescriptions->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
            <p class="stat-label">This Month</p>
        </div>
    </div>
</div>

@if($prescriptions->isEmpty())
    <div class="empty-state">
        <i class="bi bi-file-medical"></i>
        <h4>No Prescriptions Found</h4>
        <p>Your prescriptions will appear here after doctor consultations.<br>Start your health journey today!</p>
        <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary-custom btn-lg">
            <i class="bi bi-calendar-plus me-2"></i> Book an Appointment
        </a>
    </div>
@else
    <div class="prescriptions-container">
        <div class="prescriptions-row row">
            @foreach($prescriptions as $prescription)
                <div class="prescription-col col-12">
                    <div class="prescription-card card">
                        <!-- Header -->
                        <div class="prescription-header d-flex justify-content-between align-items-center">
                            <div class="prescription-date">
                                <i class="bi bi-calendar3"></i>
                                {{ $prescription->prescription_date->format('M d, Y') }}
                            </div>
                            @if($prescription->file_path)
                                <a href="{{ route('patient.prescriptions.download', $prescription) }}" 
                                   class="download-btn">
                                    <i class="bi bi-download me-1"></i> Download
                                </a>
                            @endif
                        </div>
                        
                        <!-- Card Body -->
                        <div class="card-body">
                            <!-- Doctor Information -->
                            <div class="doctor-info">
                                <div class="d-flex align-items-center">
                                    <div class="doctor-avatar">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                    <div>
                                        <h5 class="doctor-name">
                                            {{ $prescription->doctor->user->name }}
                                        </h5>
                                        <p class="doctor-specialization">{{ $prescription->doctor->specialization }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="prescription-content">
                                <!-- Diagnosis Section -->
                                @if($prescription->diagnosis)
                                    <div class="prescription-section">
                                        <div class="section-title">
                                            <div class="section-icon diagnosis-icon">
                                                <i class="bi bi-clipboard2-pulse"></i>
                                            </div>
                                            Diagnosis
                                        </div>
                                        <div class="section-content">
                                            {{ $prescription->diagnosis }}
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Medications Section -->
                                @if($prescription->medications && count($prescription->medications) > 0)
                                    <div class="prescription-section">
                                        <div class="section-title">
                                            <div class="section-icon medication-icon">
                                                <i class="bi bi-capsule"></i>
                                            </div>
                                            Medications 
                                            <span class="badge bg-success ms-2">{{ count($prescription->medications) }}</span>
                                        </div>
                                        <ul class="medication-list">
                                            @foreach($prescription->medications as $index => $medication)
                                                @if($index < 3)
                                                    <li class="medication-item">
                                                        <div class="medication-name">{{ $medication }}</div>
                                                    </li>
                                                @endif
                                            @endforeach
                                            @if(count($prescription->medications) > 3)
                                                <li class="more-medications">
                                                    <i class="bi bi-three-dots"></i>
                                                    {{ count($prescription->medications) - 3 }} more medications
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                
                                <!-- Instructions Section -->
                                @if($prescription->instructions)
                                    <div class="prescription-section">
                                        <div class="section-title">
                                            <div class="section-icon instruction-icon">
                                                <i class="bi bi-info-circle"></i>
                                            </div>
                                            Instructions
                                        </div>
                                        <div class="section-content">
                                            {{ $prescription->instructions }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Footer -->
                        @if($prescription->appointment)
                            <div class="card-footer">
                                <a href="{{ route('patient.appointments.index') }}" class="appointment-link">
                                    <i class="bi bi-calendar-event"></i>
                                    View Related Appointment
                                    <small class="d-block mt-1 opacity-75">
                                        {{ $prescription->appointment->appointment_date->format('M d, Y') }}
                                    </small>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $prescriptions->links() }}
        </div>
    </div>
@endif
@endsection