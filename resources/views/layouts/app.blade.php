<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Salut Indo Global') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
    /* News Card Effects */
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition-scale {
        transition: transform 0.5s ease;
    }
    .card:hover .transition-scale {
        transform: scale(1.05);
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .hover-scale {
        transition: transform 0.3s ease;
    }
    .hover-scale:hover {
        transform: scale(1.05);
    }

        /* Full Screen Overlay Menu for Mobile */
        @media (max-width: 768px) {
            .navbar-collapse {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(255, 255, 255, 0.98);
                z-index: 9999;
                padding: 4rem 2rem;
                text-align: center;
                display: flex;
                flex-direction: column;
                justify-content: center;
                transition: transform 0.3s ease-in-out;
                transform: translateX(100%); /* Start hidden to right */
            }
            
            /* When Bootstrap adds 'show' class, it becomes display:block relative usually. 
               We need overrides. Bootstrap 5 uses collapsing classes.
               Actually 'collapse.show' is what we target.
            */
            .navbar-collapse.show {
                transform: translateX(0);
                display: flex; /* Override bootstrap block */
            }
            
            /* Remove transform on collapsing state to avoid glitch */
            .navbar-collapse.collapsing {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(255, 255, 255, 0.98);
                z-index: 9999;
                padding: 4rem 2rem;
                display: flex;
                flex-direction: column;
                justify-content: center;
                transition: transform 0.3s ease-in-out;
                transform: translateX(100%);
            }
            .navbar-collapse.collapsing.show {
                transform: translateX(0);
            }

            .mobile-close-btn {
                position: absolute;
                top: 25px;
                right: 25px;
                font-size: 2.5rem;
                color: #dc3545;
                cursor: pointer;
                display: block !important;
            }
            
            .navbar-nav {
                width: 100%;
                gap: 20px;
            }
            
            .nav-link {
                font-size: 1.25rem;
                font-weight: 600;
            }
        }
        
        .mobile-close-btn {
            display: none;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-salut.png') }}" alt="Logo" height="50" class="me-2">
                    <span class="fw-bold text-primary">SALUT Indo Global</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Close Button for Mobile -->
                    <i class="bi bi-x-circle-fill mobile-close-btn" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"></i>
                    
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto gap-3">
                        @if(!request()->routeIs('landing'))
                            <!-- Show 'Beranda' only if NOT on Homepage -->
                            <li class="nav-item">
                                <a class="nav-link fw-bold text-dark" href="{{ url('/') }}">
                                    <i class="bi bi-arrow-left me-1"></i> Beranda
                                </a>
                            </li>
                        @else
                            <!-- Menu Items for Homepage -->
                            <li class="nav-item">
                                <a class="nav-link fw-semibold text-secondary" href="#about">Tentang Kami</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold text-secondary" href="#fakultas">Fakultas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold text-secondary" href="#fakultas">Program Studi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold text-secondary" href="#program-pilihan">Program Pilihan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold text-secondary" href="#news">Berita</a>
                            </li>
                        @endif
                    </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item dropdown">
                                <a id="guestDropdown" class="nav-link dropdown-toggle fw-bold text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i> Akun Saya
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="guestDropdown">
                                    @if (Route::has('login'))
                                        <a class="dropdown-item py-2" href="{{ route('login') }}">
                                            <i class="bi bi-box-arrow-in-right me-2 text-primary"></i> {{ __('Masuk') }}
                                        </a>
                                    @endif
                                    
                                    @if (Route::has('register'))
                                        <a class="dropdown-item py-2" href="{{ route('register') }}">
                                            <i class="bi bi-person-plus me-2 text-primary"></i> {{ __('Daftar') }}
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                @if(Auth::user()->role && Auth::user()->role->name == 'admin')
                                    <a class="nav-link fw-bold text-primary" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-1"></i> Dashboard Admin
                                    </a>
                                @elseif(Auth::user()->role && Auth::user()->role->name == 'staff')
                                    <a class="nav-link fw-bold text-primary" href="{{ route('staff.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-1"></i> Dashboard Staff
                                    </a>
                                @elseif(Auth::user()->role && Auth::user()->role->name == 'yayasan')
                                    <a class="nav-link fw-bold text-primary" href="{{ route('yayasan.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-1"></i> Dashboard Yayasan
                                    </a>
                                @else
                                    <a class="nav-link fw-bold text-primary" href="{{ route('student.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                    </a>
                                @endif
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        {{ __('Edit Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
