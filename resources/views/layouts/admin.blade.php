<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Salut Indo Global') }} - Admin</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        #sidebar-wrapper {
            height: 100vh; /* Fixed height for scrollable area */
            margin-left: -250px;
            transition: margin .25s ease-out;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            background-color: #ffffff; /* White Background */
            border-right: 1px solid #dee2e6;
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: hidden;
        }

        /* Custom Scrollbar for Sidebar */
        #sidebar-wrapper::-webkit-scrollbar {
            width: 6px;
        }
        #sidebar-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        #sidebar-wrapper::-webkit-scrollbar-thumb {
            background: #c1c1c1; 
            border-radius: 4px;
        }
        #sidebar-wrapper::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8; 
        }
        
        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
            font-weight: bold;
            color: #0d6efd; /* Corporate Blue */
            border-bottom: 1px solid #dee2e6;
        }
        
        #sidebar-wrapper .list-group {
            width: 250px;
        }
        
        #sidebar-wrapper .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem;
            font-size: 0.95rem;
            color: #495057;
        }
        
        #sidebar-wrapper .list-group-item:hover {
            background-color: #e9ecef;
            color: #0d6efd;
        }
        
        #sidebar-wrapper .list-group-item.active {
            background-color: #e7f1ff;
            color: #0d6efd;
            font-weight: 600;
            border-left: 4px solid #0d6efd;
        }
        
        /* Page Content */
        #page-content-wrapper {
            width: 100%;
            transition: margin .25s ease-out;
            margin-left: 0; /* Mobile default */
        }
        
        /* Desktop: Sidebar Visible */
        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }
            #page-content-wrapper {
                margin-left: 250px;
            }
        }
        
        /* Toggled State for Mobile */
        body.sb-sidenav-toggled #sidebar-wrapper {
            margin-left: 0;
        }
        
        /* Navbar */
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            background-color: #ffffff;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        /* Logo Responsiveness */
        .sidebar-logo {
            max-width: 80px; /* Default Desktop Compact */
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .sidebar-logo {
                max-width: 120px; /* Mobile Larger */
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase font-monospace bottom-shadow">
               <img src="{{ asset('images/sidebar-logo.png') }}" class="img-fluid mb-2 sidebar-logo" alt="Logo SALUT">
               <div class="fs-6 mt-2 text-primary">Salut Indo Global</div>
            </div>
            <div class="list-group list-group-flush my-3">
                <!-- Homepage Link -->
                <a href="{{ url('/') }}" class="list-group-item list-group-item-action bg-transparent text-primary fw-bold">
                    <i class="bi bi-house-door-fill me-2"></i>Halaman Utama
                </a>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>

                <!-- Master Data Collapsible -->
                <a href="#submenuMaster" data-bs-toggle="collapse" class="list-group-item list-group-item-action bg-transparent d-flex justify-content-between align-items-center" aria-expanded="{{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.fakultas.*') || request()->routeIs('admin.prodi.*') || request()->routeIs('admin.semester.*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-database me-2"></i>Master Data</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse list-group-submenu {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.fakultas.*') || request()->routeIs('admin.prodi.*') || request()->routeIs('admin.semester.*') ? 'show' : '' }}" id="submenuMaster">
                    <a href="{{ route('admin.roles.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.roles.*') ? 'text-primary fw-bold' : '' }}">
                        Roles
                    </a>
                    <a href="{{ route('admin.fakultas.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.fakultas.*') ? 'text-primary fw-bold' : '' }}">
                        Fakultas
                    </a>
                    <a href="{{ route('admin.prodi.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.prodi.*') ? 'text-primary fw-bold' : '' }}">
                        Program Studi
                    </a>
                    <a href="{{ route('admin.semester.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.semester.*') ? 'text-primary fw-bold' : '' }}">
                        Semester
                    </a>
                </div>

                <!-- Data Mahasiswa Collapsible -->
                <a href="#submenuMahasiswa" data-bs-toggle="collapse" class="list-group-item list-group-item-action bg-transparent d-flex justify-content-between align-items-center" aria-expanded="{{ request()->routeIs('admin.registrations.*') || request()->routeIs('admin.students.*') || request()->routeIs('admin.admissions.*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-people-fill me-2"></i>Mahasiswa</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse list-group-submenu {{ request()->routeIs('admin.registrations.*') || request()->routeIs('admin.students.*') || request()->routeIs('admin.admissions.*') ? 'show' : '' }}" id="submenuMahasiswa">
                    <a href="{{ route('admin.registrations.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.registrations.*') ? 'text-primary fw-bold' : '' }}">
                        Registrasi
                    </a>
                    <a href="{{ route('admin.admissions.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.admissions.*') ? 'text-primary fw-bold' : '' }}">
                        Persetujuan Admisi
                        @php
                            $pendingAdmissionsCount = \App\Models\User::whereHas('role', function($q){ $q->where('name', 'mahasiswa'); })->where('status', 'pending_verification')->count();
                        @endphp
                        @if($pendingAdmissionsCount > 0)
                            <span class="badge bg-danger ms-2 rounded-pill">{{ $pendingAdmissionsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.students.*') ? 'text-primary fw-bold' : '' }}">
                        Data Mahasiswa
                    </a>
                </div>
                

                <!-- CMS / Kelola Web Utama -->
                <a href="#submenuCms" data-bs-toggle="collapse" class="list-group-item list-group-item-action bg-transparent text-primary fw-bold">
                    <span><i class="bi bi-globe me-2"></i>Kelola Web</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse list-group-submenu {{ request()->routeIs('admin.home-settings.*') || request()->routeIs('admin.news.*') || request()->routeIs('admin.landing-items.*') ? 'show' : '' }}" id="submenuCms">
                    <a href="{{ route('admin.home-settings.edit') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.home-settings.*') && !request()->has('section') ? 'active' : '' }} ps-5">
                        <small>Edit Beranda & Tentang</small>
                    </a>
                    
                    <a href="{{ route('admin.landing-items.index', ['section' => 'advantage']) }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.landing-items.*') ? 'active' : '' }} ps-5">
                       <small>Item Landing Page</small>
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.news.*') ? 'active' : '' }} ps-5">
                        <small>Manajemen Berita</small>
                    </a>
                </div>

                <!-- Akademik Collapsible -->
                <a href="#submenuAkademik" data-bs-toggle="collapse" class="list-group-item list-group-item-action bg-transparent d-flex justify-content-between align-items-center" aria-expanded="{{ request()->routeIs('admin.academic.*') || request()->routeIs('admin.academic-schedules.*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-mortarboard-fill me-2"></i>Akademik</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse list-group-submenu {{ request()->routeIs('admin.academic.*') || request()->routeIs('admin.academic-schedules.*') ? 'show' : '' }}" id="submenuAkademik">
                    <a href="{{ route('admin.academic-schedules.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.academic-schedules.*') ? 'text-primary fw-bold' : '' }}">
                        Jadwal Tugas/Ujian
                    </a>
                    <a href="{{ route('admin.academic.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.academic.*') && !request()->routeIs('admin.academic-schedules.*') ? 'text-primary fw-bold' : '' }}">
                        Transkrip Nilai
                    </a>
                    <a href="{{ route('admin.documents.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.documents.*') ? 'text-primary fw-bold' : '' }}">
                        Dokumen Pusat (KTPU/KTM)
                    </a>
                </div>
                
                <!-- Keuangan Collapsible -->
                <a href="#submenuKeuangan" data-bs-toggle="collapse" class="list-group-item list-group-item-action bg-transparent d-flex justify-content-between align-items-center" aria-expanded="{{ request()->routeIs('admin.billings.*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-wallet2 me-2"></i>Keuangan</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse list-group-submenu {{ request()->routeIs('admin.billings.*') ? 'show' : '' }}" id="submenuKeuangan">
                    <a href="{{ route('admin.billings.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.billings.index') || request()->routeIs('admin.billings.create-bulk') ? 'text-primary fw-bold' : '' }}">
                        Daftar Tagihan
                    </a>
                    <a href="{{ route('admin.billings.verification') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.billings.verification') ? 'text-primary fw-bold' : '' }}">
                        Verifikasi Bayar
                    </a>
                </div>

                <!-- Non-Akademik Collapsible -->
                <a href="#submenuNonAkademik" data-bs-toggle="collapse" class="list-group-item list-group-item-action bg-transparent d-flex justify-content-between align-items-center" aria-expanded="{{ request()->routeIs('admin.non-academic.*') || request()->routeIs('admin.career-programs.*') || request()->routeIs('admin.trainings.*') || request()->routeIs('admin.lms-materials.*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-collection-play-fill me-2"></i>Non-Akademik</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse list-group-submenu {{ request()->routeIs('admin.non-academic.*') || request()->routeIs('admin.career-programs.*') || request()->routeIs('admin.trainings.*') || request()->routeIs('admin.lms-materials.*') ? 'show' : '' }}" id="submenuNonAkademik">
                    <a href="{{ route('admin.non-academic.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.non-academic.index') ? 'text-primary fw-bold' : '' }}">
                        Dashboard LMS
                    </a>
                    <a href="{{ route('admin.career-programs.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.career-programs.*') ? 'text-primary fw-bold' : '' }}">
                        Master Program
                    </a>
                    <a href="{{ route('admin.lms-materials.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.lms-materials.*') ? 'text-primary fw-bold' : '' }}">
                        Materi Belajar
                    </a>
                    <a href="{{ route('admin.trainings.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.trainings.*') ? 'text-primary fw-bold' : '' }}">
                        Jadwal Pelatihan
                    </a>
                </div>
                
                <!-- Manajemen Mitra & Afiliasi Collapsible -->
                <a href="#submenuMitra" data-bs-toggle="collapse" class="list-group-item list-group-item-action bg-transparent d-flex justify-content-between align-items-center" aria-expanded="{{ request()->routeIs('admin.mitras.*') || request()->routeIs('admin.affiliators.*') || request()->routeIs('admin.withdrawals.*') ? 'true' : 'false' }}">
                    <span><i class="bi bi-diagram-3-fill me-2"></i>Mitra & Afiliasi</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse list-group-submenu {{ request()->routeIs('admin.mitras.*') || request()->routeIs('admin.affiliators.*') || request()->routeIs('admin.withdrawals.*') ? 'show' : '' }}" id="submenuMitra">
                    <a href="{{ route('admin.mitras.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.mitras.*') ? 'text-primary fw-bold' : '' }}">
                        Data Mitra
                    </a>
                    <a href="{{ route('admin.affiliators.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.affiliators.*') ? 'text-primary fw-bold' : '' }}">
                        Data Affiliator
                    </a>
                    <a href="{{ route('admin.withdrawals.index') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('admin.withdrawals.*') ? 'text-primary fw-bold' : '' }}">
                        Pencairan Poin
                        @php
                            $pendingWd = \App\Models\Withdrawal::where('status', 'pending')->count();
                        @endphp
                        @if($pendingWd > 0)
                            <span class="badge bg-warning text-dark ms-2">{{ $pendingWd }}</span>
                        @endif
                    </a>
                </div>

                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action bg-transparent text-danger mt-3">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->
        
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <!-- Sidebar Toggle (Mobile & Desktop) -->
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle me-3">
                        <i class="bi bi-list fs-2 text-primary"></i>
                    </button>
                    
                    <h2 class="fs-6 fs-md-4 m-0 text-muted">@yield('title', 'Admin Dashboard')</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle"); // Desktop
        var sidebarToggleTop = document.getElementById("sidebarToggleTop"); // Mobile

        function toggleMenu() {
            el.classList.toggle("toggled");
            document.body.classList.toggle("sb-sidenav-toggled");
        }

        if(toggleButton) {
            toggleButton.onclick = function(e) {
                e.preventDefault();
                toggleMenu();
            };
        }
        
        if(sidebarToggleTop) {
            sidebarToggleTop.onclick = function(e) {
                e.preventDefault();
                toggleMenu();
            };
        }
    </script>
    @stack('modals')
    @stack('scripts')
</body>
</html>
