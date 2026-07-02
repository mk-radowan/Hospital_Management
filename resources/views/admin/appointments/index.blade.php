@extends('layouts.dashboard')

@section('title', 'Manage Appointments')

@push('styles')
<style>
    .appointments-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .appointments-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: none;
        font-weight: 600;
        color: #2d3748;
        padding: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }

    .status-confirmed {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-group-sm .btn {
        padding: 0.4rem 0.6rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-group-sm .btn:hover {
        transform: translateY(-1px);
    }

    .form-select-sm {
        padding: 0.4rem 2rem 0.4rem 0.8rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-size: 0.875rem;
        background-position: right 0.5rem center;
        background-size: 16px 12px;
        min-width: 120px;
    }

    .form-select-sm:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .status-select {
        padding: 0.4rem 2rem 0.4rem 0.8rem !important;
        min-width: 120px !important;
        font-weight: 500;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
        color: #667eea;
    }

    .filter-form .form-control,
    .filter-form .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .filter-form .form-control:focus,
    .filter-form .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .stats-row {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.8rem 1.2rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        text-align: center;
        min-width: 100px;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
    }

    .stat-label {
        font-size: 0.8rem;
        opacity: 0.9;
        margin: 0;
    }

    .appointments-count {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-left: 1rem;
    }

    @media (max-width: 768px) {
        .appointments-header {
            padding: 1.5rem;
        }

        .filter-card {
            padding: 1rem;
        }

        .stats-row {
            flex-wrap: wrap;
        }

        .table-responsive {
            font-size: 0.875rem;
        }

        .btn-group-sm {
            flex-direction: column;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<!-- Enhanced Header -->
<div class="appointments-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-2">
                <i class="bi bi-calendar-check me-2"></i>
                Manage Appointments
                <span class="appointments-count">{{ $appointments->count() }} Total</span>
            </h1>
            <p class="mb-0 opacity-90">View and manage all patient appointments</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-outline-light">
                <i class="bi bi-calendar-plus me-2"></i> Create New
            </a>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="stats-row">
        <div class="stat-item">
            <p class="stat-number">{{ $appointments->where('status', 'pending')->count() }}</p>
            <p class="stat-label">Pending</p>
        </div>
        <div class="stat-item">
            <p class="stat-number">{{ $appointments->where('status', 'confirmed')->count() }}</p>
            <p class="stat-label">Confirmed</p>
        </div>
        <div class="stat-item">
            <p class="stat-number">{{ $appointments->where('status', 'completed')->count() }}</p>
            <p class="stat-label">Completed</p>
        </div>
        <div class="stat-item">
            <p class="stat-number">{{ $appointments->where('status', 'cancelled')->count() }}</p>
            <p class="stat-label">Cancelled</p>
        </div>
    </div>
</div>

<!-- Enhanced Filter Section -->
<div class="filter-card">
    <h5 class="mb-3">
        <i class="bi bi-funnel text-primary me-2"></i>
        Filter Appointments
    </h5>
    <form method="GET" class="filter-form">
        <div class="row g-3">
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" id="status">
                    <option value="">All Status</option>
                    @foreach($statuses as $key => $value)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="doctor_id" class="form-label">Doctor</label>
                <select class="form-select" name="doctor_id" id="doctor_id">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->user->name }} ({{ $doctor->specialization }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" class="form-control" name="date_from" id="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" class="form-control" name="date_to" id="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i> Clear
                </a>
                <button type="button" class="btn btn-outline-success ms-2" onclick="exportAppointments()">
                    <i class="bi bi-download me-1"></i> Export
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Appointments Table -->
<div class="appointments-table">
    @if($appointments->isEmpty())
        <div class="empty-state">
            <i class="bi bi-calendar-check"></i>
            <h4>No Appointments Found</h4>
            <p class="mb-4">No appointments match your current filters or no appointments have been created yet.</p>
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-calendar-plus me-2"></i> Create First Appointment
            </a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-primary">{{ $appointment->appointment_date->format('M d, Y') }}</strong>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $appointment->appointment_time->format('h:i A') }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-person-circle text-primary fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <strong>{{ $appointment->patient->user->name }}</strong><br>
                                    <small class="text-muted">{{ $appointment->patient->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-person-badge text-success fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <strong>{{ $appointment->doctor->user->name }}</strong><br>
                                    <small class="text-muted">{{ $appointment->doctor->specialization }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong class="text-success">Tk {{ number_format($appointment->consultation_fee, 0) }}</strong>
                        </td>
                        <td>
                            <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm status-select" onchange="this.form.submit()" 
                                        data-current-status="{{ $appointment->status }}">
                                    @foreach($statuses as $key => $value)
                                        <option value="{{ $key }}" {{ $appointment->status === $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" 
                                   class="btn btn-outline-primary" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                                   class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this appointment?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Footer -->
        <div class="p-3 bg-light border-top">
            <div class="row text-center">
                <div class="col-md-3">
                    <strong>Total: {{ $appointments->count() }}</strong>
                </div>
                <div class="col-md-3">
                    <span class="status-badge status-pending">
                        Pending: {{ $appointments->where('status', 'pending')->count() }}
                    </span>
                </div>
                <div class="col-md-3">
                    <span class="status-badge status-confirmed">
                        Confirmed: {{ $appointments->where('status', 'confirmed')->count() }}
                    </span>
                </div>
                <div class="col-md-3">
                    <span class="status-badge status-completed">
                        Completed: {{ $appointments->where('status', 'completed')->count() }}
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Color-code status selects based on current status
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelects = document.querySelectorAll('.status-select');
        
        statusSelects.forEach(select => {
            updateStatusSelectColor(select);
            
            select.addEventListener('change', function() {
                updateStatusSelectColor(this);
            });
        });
        
        function updateStatusSelectColor(select) {
            const status = select.value;
            select.className = 'form-select form-select-sm status-select';
            
            switch(status) {
                case 'pending':
                    select.style.backgroundColor = '#fef3c7';
                    select.style.color = '#d97706';
                    break;
                case 'confirmed':
                    select.style.backgroundColor = '#dbeafe';
                    select.style.color = '#1d4ed8';
                    break;
                case 'completed':
                    select.style.backgroundColor = '#d1fae5';
                    select.style.color = '#065f46';
                    break;
                case 'cancelled':
                    select.style.backgroundColor = '#fee2e2';
                    select.style.color = '#991b1b';
                    break;
                default:
                    select.style.backgroundColor = '';
                    select.style.color = '';
            }
        }
    });

    // Export functionality (placeholder)
    function exportAppointments() {
        // You can implement CSV/Excel export here
        alert('Export functionality would be implemented here');
    }

    // Auto-refresh every 30 seconds for real-time updates
    let autoRefresh;
    
    function startAutoRefresh() {
        autoRefresh = setInterval(() => {
            if (!document.hidden) {
                // Only refresh if page is visible
                const currentUrl = new URL(window.location);
                fetch(currentUrl)
                    .then(response => response.text())
                    .then(html => {
                        // Update only the appointments count in header
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        const newCount = newDoc.querySelector('.appointments-count');
                        const currentCount = document.querySelector('.appointments-count');
                        
                        if (newCount && currentCount && newCount.textContent !== currentCount.textContent) {
                            // Show notification that data has changed
                            showUpdateNotification();
                        }
                    })
                    .catch(error => console.log('Auto-refresh failed:', error));
            }
        }, 30000); // 30 seconds
    }

    function showUpdateNotification() {
        const notification = document.createElement('div');
        notification.className = 'alert alert-info position-fixed';
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 300px;';
        notification.innerHTML = `
            <i class="bi bi-info-circle me-2"></i>
            New updates available. 
            <button class="btn btn-sm btn-outline-primary ms-2" onclick="window.location.reload()">
                Refresh
            </button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 10000);
    }

    // Start auto-refresh
    startAutoRefresh();

    // Stop auto-refresh when page becomes hidden
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(autoRefresh);
        } else {
            startAutoRefresh();
        }
    });
</script>
@endpush
@endsection