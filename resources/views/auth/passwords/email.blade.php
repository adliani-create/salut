@extends('layouts.app')

@section('content')
<div class="login-overlay d-flex align-items-center justify-content-center">
    <div class="login-card p-5 shadow-lg bg-white rounded-4 animate__animated animate__fadeInUp">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo-salut.png') }}" alt="SALUT Indo Global" height="60" class="mb-3">
            <h2 class="fw-bold text-dark">Reset Password</h2>
            <p class="text-muted">Enter your email to receive a reset link.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label fw-bold small text-uppercase text-secondary">{{ __('Email Address') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-secondary"></i></span>
                    <input id="email" type="email" class="form-control form-control-lg bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>

            <div class="text-center text-secondary small">
                Remember your password? 
                <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary">Login</a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Full Screen Overlay */
    .login-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 9999;
        background-color: #0d3d56;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.03) 2%, transparent 2%, transparent 100%),
            radial-gradient(circle at 90% 80%, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.03) 4%, transparent 4%, transparent 100%),
            linear-gradient(135deg, #0a2e42 0%, #0d3d56 100%);
        background-size: cover;
    }

    .login-card {
        width: 100%;
        max-width: 450px;
        border: none;
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
