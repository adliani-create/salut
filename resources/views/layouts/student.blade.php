<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Salut Indo Global') }} - Mahasiswa</title>
    
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
        
        /* Sidebar Styles (Matching Admin Layout) */
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -250px;
            transition: margin .25s ease-out;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            background-color: #ffffff; /* White Background */
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
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

        .avatar-placeholder {
            width: 40px;
            height: 40px;
            background-color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
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
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
             <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase font-monospace bottom-shadow">
               <img src="{{ asset('images/sidebar-logo.png') }}" class="img-fluid mb-2 sidebar-logo" alt="Logo SALUT">
               <div class="fs-6 mt-2 text-primary">Salut Indo Global</div>
            </div>

            <div class="list-group list-group-flush my-3">
                 <a href="{{ url('/') }}" class="list-group-item list-group-item-action bg-transparent text-primary fw-bold">
                    <i class="bi bi-house-door-fill me-2"></i>Halaman Utama
                </a>

                <a href="{{ route('student.dashboard') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                
                <a href="#" class="list-group-item list-group-item-action bg-transparent d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#submenuAkademik">
                    <span><i class="bi bi-book-half me-2"></i> Akademik</span>
                     <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse list-group-submenu {{ request()->routeIs('student.academic') ? 'show' : '' }}" id="submenuAkademik">
                    <a href="{{ route('student.academic') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('student.academic') ? 'text-primary fw-bold' : '' }}">
                        Transkrip & KHS
                    </a>
                </div>
                
                <a href="#" class="list-group-item list-group-item-action bg-transparent d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#submenuNonAkademik">
                    <span><i class="bi bi-collection-play-fill me-2"></i> Non-Akademik</span>
                     <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse list-group-submenu {{ request()->routeIs('student.non-academic') ? 'show' : '' }}" id="submenuNonAkademik">
                     <a href="{{ route('student.non-academic') }}" class="list-group-item list-group-item-action bg-transparent border-0 ps-5 {{ request()->routeIs('student.non-academic') ? 'text-primary fw-bold' : '' }}">
                        LMS & Pelatihan
                    </a>
                </div>

                <a href="{{ route('student.billing.index') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('student.billing.*') ? 'active' : '' }}">
                   <i class="bi bi-wallet2 me-2"></i> Keuangan
                </a>

                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action bg-transparent text-danger mt-3">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle me-3">
                        <i class="bi bi-list fs-2 text-primary"></i>
                    </button>
                    
                    <h2 class="fs-4 m-0 text-muted">@yield('title', 'Student Dashboard')</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold d-flex align-items-center gap-2" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                                <li>
                                    <a class="dropdown-item rounded-3 py-2" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-gear me-2 text-primary"></i> Edit Profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-3 py-2 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                @yield('content')
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script>
        var el = document.getElementById("wrapper");
        var sidebarToggleTop = document.getElementById("sidebarToggleTop");

        function toggleMenu() {
            el.classList.toggle("toggled");
            document.body.classList.toggle("sb-sidenav-toggled");
        }
        
        if(sidebarToggleTop) {
            sidebarToggleTop.onclick = function(e) {
                e.preventDefault();
                toggleMenu();
            };
        }
    </script>
    @stack('scripts')
</body>
</html>
