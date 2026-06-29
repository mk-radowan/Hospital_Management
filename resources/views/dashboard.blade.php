<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard - Hospitally')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #2c5aa0 !important;
        }
        .bg-primary-custom {
            background-color: #2c5aa0 !important;
        }
        .text-primary-custom {
            color: #2c5aa0 !important;
        }
        .btn-primary-custom {
            background-color: #2c5aa0;
            border-color: #2c5aa0;
        }
        .btn-primary-custom:hover {
            background-color: #1e3f73;
            border-color: #1e3f73;
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .sidebar .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            border-radius: 0;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: #2c5aa0;
        }
        .sidebar .nav-link.active {
            background-color: #2c5aa0;
            color: white;
        }
        .main-content {
            min-height: calc(100vh - 56px);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        .stats-card-green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        .stats-card-orange {
            background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
        }
        .stats-card-red {
            background: linear-gradient(135deg, #c21500 0%, #ffc500 100%);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-hospital"></i> Hospitally
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            @if(auth()->user()->role === 'patient')
                                <li><a class="dropdown-item" href="{{ route('patient.profile.show') }}">My Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('patient.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            @elseif(auth()->user()->role === 'doctor')
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('doctor.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            @elseif(auth()->user()->role === 'admin')
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    @yield('sidebar')
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4 main-content">
                <div class="pt-3">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>