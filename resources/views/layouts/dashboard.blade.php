<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Hospitally - Hospital Management System')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2c5aa0;
            --primary-dark: #1e3f73;
            --sidebar-width: 280px;
            --navbar-height: 76px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            padding-top: var(--navbar-height);
            /* Add top padding for fixed navbar */
            overflow-x: hidden;
        }

        html {
            overflow-x: hidden;
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
        }

        .bg-primary-custom {
            background-color: var(--primary-color) !important;
        }

        .text-primary-custom {
            color: var(--primary-color) !important;

        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
        }

        /* Enhanced Navigation Styles - FIXED STICKY NAVBAR */
        .dashboard-navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            height: var(--navbar-height);
            position: fixed !important;
            /* Make it truly fixed */
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            z-index: 1030 !important;
        }

        /* Fix navbar content alignment */
        .navbar-nav {
            margin-left: auto;
        }

        /* FIXED: Remove Bootstrap's automatic dropdown caret */
        .dropdown-toggle::after,
        .dropup .dropdown-toggle::after,
        .dropend .dropdown-toggle::after,
        .dropstart .dropdown-toggle::before {
            display: none !important;
            content: none !important;
            border: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 0 !important;
            height: 0 !important;
            opacity: 0 !important;
            visibility: hidden !important;
            position: absolute !important;
            pointer-events: none !important;
        }

        /* FIX DROPDOWN POSITIONING */
        .navbar .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            z-index: 1050 !important;
            min-width: 250px !important;
            margin-top: 0.125rem !important;
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.15) !important;
            border-radius: 8px !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            padding: 0.5rem 0 !important;
        }

        .navbar .dropdown-menu.show {
            display: block !important;
        }

        .navbar .dropdown-item {
            color: #212529 !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.9rem !important;
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
        }

        .navbar .dropdown-item:hover,
        .navbar .dropdown-item:focus {
            background-color: rgba(44, 90, 160, 0.1) !important;
            color: var(--primary-color) !important;
        }

        .navbar .dropdown-item i {
            margin-right: 0.5rem !important;
            width: 16px !important;
            text-align: center !important;
        }

        .navbar .dropdown-divider {
            margin: 0.5rem 0 !important;
            border-top: 1px solid #e9ecef !important;
        }

        /* Fix form buttons in dropdown */
        .navbar .dropdown-item button {
            background: none !important;
            border: none !important;
            color: #212529 !important;
            font-size: 0.9rem !important;
            padding: 0 !important;
            text-align: left !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            font-family: inherit !important;
        }

        .navbar .dropdown-item button:hover {
            background: none !important;
            color: var(--primary-color) !important;
        }

        /* Custom dropdown arrow styles */
        .navbar .nav-link {
            display: flex !important;
            align-items: center !important;
        }

        .navbar .dropdown-toggle .dropdown-arrow {
            margin-left: 0.5rem !important;
            font-size: 0.8rem !important;
            transition: transform 0.2s ease !important;
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .navbar .dropdown-toggle:hover .dropdown-arrow {
            color: white !important;
        }

        .navbar .dropdown-toggle[aria-expanded="true"] .dropdown-arrow {
            transform: rotate(180deg) !important;
        }

        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            /* Adjust for fixed navbar */
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
            border-right: 1px solid #dee2e6;
            box-shadow: 2px 0 4px rgba(0, 0, 0, .05);
            z-index: 1000;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav .nav-link {
            color: #495057;
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(44, 90, 160, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .sidebar-nav .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 2px 8px rgba(44, 90, 160, 0.3);
        }

        .sidebar-nav .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            max-width: calc(100% - var(--sidebar-width));
            min-height: calc(100vh - var(--navbar-height));
            padding: 1.5rem;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .content-wrapper {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, .05);
            margin: 0;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Role Badge Styles */
        .role-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-left: 0.5rem;
        }

        .role-patient {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .role-doctor {
            background-color: #d4edda;
            color: #155724;
        }

        .role-admin {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Stats Cards */
        .stats-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, .15);
        }

        .stats-card-green {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }

        .stats-card-orange {
            background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%);
            color: white;
        }

        .stats-card-red {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            color: white;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            body {
                padding-top: var(--navbar-height);
            }

            .sidebar {
                left: -100%;
                transition: left 0.3s ease;
                width: var(--sidebar-width);
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                max-width: 100%;
                padding: 1rem;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .mobile-nav-toggle {
                display: block !important;
            }
        }

        .mobile-nav-toggle {
            display: none;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: ">";
            color: #6c757d;
        }

        /* Fix container fluid padding */
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Ensure proper alignment */
        .d-flex {
            margin: 0;
            padding: 0;
        }

        /* Additional Bootstrap fixes */
        .row {
            margin-left: 0;
            margin-right: 0;
            max-width: 100%;
        }

        [class*="col-"] {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Loading animation for smooth transitions */
        .navbar,
        .sidebar {
            transition: all 0.3s ease;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Top Navigation - FIXED STICKY NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-navbar">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-hospital me-2"></i>
                Hospitally
            </a>

            <!-- Mobile menu toggle -->
            <button class="btn btn-outline-light mobile-nav-toggle me-2" type="button" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- User Menu - properly aligned to the right -->
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                                <i class="bi bi-chevron-down dropdown-arrow"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('patient.login') }}">
                                        <i class="bi bi-person"></i> Patient Login
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('doctor.login') }}">
                                        <i class="bi bi-person-badge"></i> Doctor Login
                                    </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.login') }}">
                                        <i class="bi bi-shield-check"></i> Admin Login
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patient.register') }}">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ auth()->user()->name }}
                                <span class="role-badge role-{{ auth()->user()->role }}">
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>
                                <i class="bi bi-chevron-down dropdown-arrow"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @if (auth()->user()->role === 'patient')
                                    <li><a class="dropdown-item" href="{{ route('patient.profile.show') }}">
                                            <i class="bi bi-person"></i> My Profile
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('patient.appointments.index') }}">
                                            <i class="bi bi-calendar-check"></i> My Appointments
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('patient.logout') }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-box-arrow-right"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                @elseif(auth()->user()->role === 'doctor')
                                    <li><a class="dropdown-item" href="#">
                                            <i class="bi bi-person"></i> My Profile
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('doctor.logout') }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-box-arrow-right"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                @elseif(auth()->user()->role === 'admin')
                                    <li><a class="dropdown-item" href="#">
                                            <i class="bi bi-person"></i> My Profile
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-box-arrow-right"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item ms-2">
                            @php
                                $logoutRoute = match (auth()->user()->role) {
                                    'patient' => route('patient.logout'),
                                    'doctor' => route('doctor.logout'),
                                    'admin' => route('admin.logout'),
                                    default => '#',
                                };
                            @endphp
                            <form action="{{ $logoutRoute }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar Navigation -->
        <nav class="sidebar" id="sidebar">
            @auth
                <div class="sidebar-nav">
                    @if (auth()->user()->role === 'patient')
                        <!-- Patient Navigation -->
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}"
                                    href="{{ route('patient.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('patient.profile.*') ? 'active' : '' }}"
                                    href="{{ route('patient.profile.show') }}">
                                    <i class="bi bi-person"></i> My Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('patient.appointments.*') ? 'active' : '' }}"
                                    href="{{ route('patient.appointments.index') }}">
                                    <i class="bi bi-calendar-check"></i> My Appointments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('patient.appointments.create') ? 'active' : '' }}"
                                    href="{{ route('patient.appointments.create') }}">
                                    <i class="bi bi-calendar-plus"></i> Book Appointment
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('patient.prescriptions.*') ? 'active' : '' }}"
                                    href="{{ route('patient.prescriptions.index') }}">
                                    <i class="bi bi-file-medical"></i> My Prescriptions
                                </a>
                            </li>
                        </ul>
                    @elseif(auth()->user()->role === 'doctor')
                        <!-- Doctor Navigation -->
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}"
                                    href="{{ route('doctor.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('doctor.appointments.*') ? 'active' : '' }}"
                                    href="{{ route('doctor.appointments.index') }}">
                                    <i class="bi bi-calendar-check"></i> My Appointments
                                </a>
                            </li>

                        </ul>
                    @elseif(auth()->user()->role === 'admin')
                        <!-- Admin Navigation -->
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}"
                                    href="{{ route('admin.doctors.index') }}">
                                    <i class="bi bi-person-badge"></i> Manage Doctors
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}"
                                    href="{{ route('admin.patients.index') }}">
                                    <i class="bi bi-people"></i> Manage Patients
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}"
                                    href="{{ route('admin.appointments.index') }}">
                                    <i class="bi bi-calendar-check"></i> All Appointments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.pharmacy-categories.*') ? 'active' : '' }}"
                                    href="{{ route('admin.pharmacy-categories.index') }}">
                                    <i class="bi bi-capsule"></i> Pharmacy Categories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.legacy.*') ? 'active' : '' }}"
                                    href="{{ route('admin.legacy.index') }}">
                                    <i class="bi bi-grid"></i> Legacy Feature Map
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            @endauth
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Custom dropdown toggle function
        function toggleDropdown(element) {
            const dropdown = element.parentElement;
            const menu = dropdown.querySelector('.dropdown-menu');
            const arrow = element.querySelector('.dropdown-arrow');

            // Close all other dropdowns first
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                if (menu !== element.nextElementSibling) {
                    menu.classList.remove('show');
                    const otherArrow = menu.previousElementSibling.querySelector('.dropdown-arrow');
                    if (otherArrow) {
                        otherArrow.style.transform = '';
                        menu.previousElementSibling.setAttribute('aria-expanded', 'false');
                    }
                }
            });

            // Toggle current dropdown
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
                arrow.style.transform = '';
                element.setAttribute('aria-expanded', 'false');
            } else {
                menu.classList.add('show');
                arrow.style.transform = 'rotate(180deg)';
                element.setAttribute('aria-expanded', 'true');
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-nav-toggle');

            // Handle sidebar
            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                !toggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }

            // Handle dropdowns
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                    const arrow = menu.previousElementSibling.querySelector('.dropdown-arrow');
                    if (arrow) {
                        arrow.style.transform = '';
                        menu.previousElementSibling.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });

        // Enhanced scroll behavior for navbar
        let lastScrollTop = 0;
        const navbar = document.querySelector('.dashboard-navbar');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // Add shadow on scroll
            if (scrollTop > 10) {
                navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.2)';
            } else {
                navbar.style.boxShadow = '0 2px 4px rgba(0,0,0,.1)';
            }

            lastScrollTop = scrollTop;
        });
    </script>

    @stack('scripts')
</body>

</html>
