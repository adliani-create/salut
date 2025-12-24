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
            overflow-y: auto; /* Enable scrolling if content exceeds height */
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
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase">
                <i class="bi bi-mortarboard-fill me-2"></i>{{ config('app.name') }}
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.roles.index') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock me-2"></i>Roles
                </a>
                <a href="{{ route('admin.fakultas.index') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.fakultas.*') ? 'active' : '' }}">
                    <i class="bi bi-building me-2"></i>Fakultas
                </a>
                <a href="{{ route('admin.prodi.index') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.prodi.*') ? 'active' : '' }}">
                    <i class="bi bi-book me-2"></i>Program Studi
                </a>
                <a href="{{ route('admin.semester.index') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.semester.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar3 me-2"></i>Semester
                </a>
                
                <div class="sidebar-heading text-uppercase fs-6 text-muted mt-3 mb-1 ms-3">Non-Akademik</div>
                <a href="{{ route('admin.lms-materials.index') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.lms-materials.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-album me-2"></i>LMS Lokal
                </a>
                <a href="{{ route('admin.trainings.index') }}" class="list-group-item list-group-item-action bg-transparent {{ request()->routeIs('admin.trainings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check me-2"></i>Jadwal Pelatihan
                </a>
                
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
                    <i class="bi bi-list fs-2 me-3" id="menu-toggle" style="cursor: pointer; color: #0d6efd;"></i>
                    <h2 class="fs-4 m-0 text-muted">@yield('title', 'Admin Dashboard')</h2>
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

            <div class="container-fluid px-4">
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
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
            document.body.classList.toggle("sb-sidenav-toggled");
        };
    </script>
</body>
</html>
