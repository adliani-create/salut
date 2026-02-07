@extends('layouts.app')

@section('content')
<div class="login-overlay d-flex align-items-center justify-content-center">
    <div class="login-card p-5 shadow-lg bg-white rounded-4 animate__animated animate__fadeInUp">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo-salut.png') }}" alt="SALUT Indo Global" height="60" class="mb-3">
            <h2 class="fw-bold text-dark">Welcome Back</h2>
            <p class="text-muted">Please sign in to continue</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label fw-bold small text-uppercase text-secondary">{{ __('Student ID / Email') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-secondary"></i></span>
                    <input id="email" type="email" class="form-control form-control-lg bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label fw-bold small text-uppercase text-secondary">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none small text-primary fw-bold" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-secondary"></i></span>
                    <input id="password" type="password" class="form-control form-control-lg bg-light border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                </div>
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label text-secondary small" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                    {{ __('Login') }}
                </button>
            </div>

            <div class="text-center text-secondary small">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary">Register</a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Full Screen Overlay to Hide Navbar/Footer from Layout if needed */
    .login-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 9999;
        /* Deep Corporate Blue Background with Geometric Pattern Overlay */
        background-color: #0d3d56;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.03) 2%, transparent 2%, transparent 100%),
            radial-gradient(circle at 90% 80%, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.03) 4%, transparent 4%, transparent 100%),
            linear-gradient(135deg, #0a2e42 0%, #0d3d56 100%);
        background-size: cover;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        border: none;
        transition: transform 0.3s ease;
    }

    .form-control:focus {
        box-shadow: none;
        background-color: #fff !important;
        border-color: #0d6efd;
    }

    .form-control {
        font-size: 0.95rem;
    }
    
    .input-group-text {
        border-color: #ced4da;
    }

    .btn-primary {
        background: linear-gradient(45deg, #0d6efd, #0099ff);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4) !important;
    }
</style>
@endsection
