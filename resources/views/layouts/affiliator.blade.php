<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Salut Indo Global') }} - Affiliator Panel</title>
    
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
            min-height: 100vh;
            margin-left: -250px;
            transition: margin .25s ease-out;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            background-color: #ffffff; /* White Background */
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
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
            margin-left: 0;
        }
        
        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { margin-left: 250px; }
        }
        
        /* Toggled State for Mobile */
        body.sb-sidenav-toggled #sidebar-wrapper {
            margin-left: 0;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        /* Overlay for mobile */
        #sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(2px);
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        body.sb-sidenav-toggled #sidebar-overlay {
            display: block;
            opacity: 1;
        }

        /* Hamburger Toggle on top of sidebar */
        #sidebarToggleTop {
            position: relative;
            z-index: 1050;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            background-color: #ffffff;
        }

        /* Logo Responsiveness */
        .sidebar-logo {
            max-width: 80px; 
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .sidebar-logo {
                max-width: 120px;
            }
        }

        /* Dropdown Animation */
        .animate {
            animation-duration: 0.3s;
            -webkit-animation-duration: 0.3s;
            animation-fill-mode: both;
            -webkit-animation-fill-mode: both;
        }

        @keyframes slideIn {
            0% {
                transform: translateY(1rem);
                opacity: 0;
            }
            100% {
                transform: translateY(0rem);
                opacity: 1;
            }
        }

        .slideIn {
            -webkit-animation-name: slideIn;
            animation-name: slideIn;
        }
    </style>
</head>
<body>
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay"></div>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase font-monospace bottom-shadow">
               <img src="{{ asset('images/sidebar-logo.png') }}" class="img-fluid mb-2 sidebar-logo" alt="Logo SALUT">
               <div class="fs-6 mt-2 text-primary">Salut Indo Global</div>
            </div>
            
            <div class="list-group list-group-flush my-3">
                <div class="text-uppercase text-muted small fw-bold px-4 mb-2 mt-2" style="font-size: 0.75rem; letter-spacing: 1px;">Menu Utama</div>
                <a href="{{ route('affiliator.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('affiliator.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill me-3"></i>Dashboard
                </a>
                
                <div class="text-uppercase text-muted small fw-bold px-4 mb-2 mt-4" style="font-size: 0.75rem; letter-spacing: 1px;">Kegiatan Akuisisi</div>
                <a href="{{ route('affiliator.students.create') }}" class="list-group-item list-group-item-action {{ request()->routeIs('affiliator.students.create') ? 'active' : '' }}">
                    <i class="bi bi-person-plus-fill me-3"></i>Form Input Prospek
                </a>
                <a href="{{ route('affiliator.students.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('affiliator.students.index') ? 'active' : '' }}">
                    <i class="bi bi-list-check me-3"></i>Daftar Mahasiswa Saya
                </a>

                <div class="text-uppercase text-muted small fw-bold px-4 mb-2 mt-4" style="font-size: 0.75rem; letter-spacing: 1px;">Keuangan</div>
                <a href="{{ route('affiliator.finance.commissions') }}" class="list-group-item list-group-item-action {{ request()->routeIs('affiliator.finance.*') ? 'active' : '' }}">
                    <i class="bi bi-wallet2 me-3"></i>Komisi & Penarikan
                </a>

                <div class="text-uppercase text-muted small fw-bold px-4 mb-2 mt-4" style="font-size: 0.75rem; letter-spacing: 1px;">Sistem</div>
                <a href="{{ route('affiliator.profile.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('affiliator.profile.edit') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill me-3"></i>Pengaturan Profil
                </a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action text-danger mt-2">
                    <i class="bi bi-box-arrow-right me-3"></i>Keluar
                </a>
            </div>
        </div>
        
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3 px-4">
                <div class="d-flex align-items-center">
                    <button id="sidebarToggleTop" class="btn btn-light rounded-circle me-3 d-md-none">
                        <i class="bi bi-list fs-4 text-dark"></i>
                    </button>
                    <h4 class="m-0 fw-bold text-gray-800">@yield('title', 'Dashboard')</h4>
                </div>

                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle second-text fw-bold d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-md-block text-dark">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}?v={{ time() }}" alt="" class="rounded-circle object-fit-cover shadow-sm border" width="40" height="40">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm border" style="width: 40px; height: 40px; font-size: 1rem;">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 mt-2 rounded-4 animate slideIn" aria-labelledby="navbarDropdown">
                            <li>
                                <div class="px-3 py-2">
                                    <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 150px;">{{ Auth::user()->email }}</div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('affiliator.profile.edit') }}"><i class="bi bi-person me-2 text-primary"></i>Profil Saya</a></li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar Sistem
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script>
        var sidebarToggleTop = document.getElementById("sidebarToggleTop");
        var wrapper = document.getElementById("wrapper");
        var overlay = document.getElementById("sidebar-overlay");

        function toggleSidebar(e) {
            e.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
        }

        if(sidebarToggleTop) {
             sidebarToggleTop.onclick = toggleSidebar;
        }
        
        if(overlay) {
             overlay.onclick = toggleSidebar;
        }
    </script>
    @stack('scripts')
</body>
</html>
