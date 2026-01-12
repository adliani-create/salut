@extends('layouts.app')

@section('content')
<div class="login-overlay d-flex align-items-center justify-content-center">
    <div class="login-card p-5 shadow-lg bg-white rounded-4 animate__animated animate__fadeInUp">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo-salut.png') }}" alt="SALUT Indo Global" height="60" class="mb-3">
            <h2 class="fw-bold text-dark">Create Account</h2>
            <p class="text-muted">Join us today! Enter your details below.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-bold small text-uppercase text-secondary">{{ __('Registration Type') }}</label>
                <div class="d-flex gap-3">
                    <div class="form-check card-radio flex-fill">
                        <input class="form-check-input d-none" type="radio" name="registration_type" id="type_maba" value="maba" checked onchange="toggleNimField()">
                        <label class="form-check-label btn btn-outline-primary w-100 py-2 rounded-3 text-center fw-bold" for="type_maba">
                            Mahasiswa Baru
                        </label>
                    </div>
                    <div class="form-check card-radio flex-fill">
                        <input class="form-check-input d-none" type="radio" name="registration_type" id="type_active" value="active" onchange="toggleNimField()">
                        <label class="form-check-label btn btn-outline-primary w-100 py-2 rounded-3 text-center fw-bold" for="type_active">
                            Mahasiswa Aktif
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4 d-none" id="nim_field">
                <label for="nim" class="form-label fw-bold small text-uppercase text-secondary">{{ __('UT Student ID (NIM)') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-heading text-secondary"></i></span>
                    <input id="nim" type="text" class="form-control form-control-lg bg-light border-start-0 ps-0 @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim') }}" placeholder="Enter your NIM">
                </div>
                @error('nim')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="form-label fw-bold small text-uppercase text-secondary">{{ __('Full Name') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-secondary"></i></span>
                    <input id="name" type="text" class="form-control form-control-lg bg-light border-start-0 ps-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                </div>
                @error('name')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="form-label fw-bold small text-uppercase text-secondary">{{ __('Email Address') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-secondary"></i></span>
                    <input id="email" type="email" class="form-control form-control-lg bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email">
                </div>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-bold small text-uppercase text-secondary">{{ __('Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-secondary"></i></span>
                    <input id="password" type="password" class="form-control form-control-lg bg-light border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a password">
                </div>
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password-confirm" class="form-label fw-bold small text-uppercase text-secondary">{{ __('Confirm Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill text-secondary"></i></span>
                    <input id="password-confirm" type="password" class="form-control form-control-lg bg-light border-start-0 ps-0" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                </div>
            </div>

            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                    {{ __('Register') }}
                </button>
            </div>

            <div class="text-center text-secondary small">
                Already have an account? 
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
        overflow-y: auto; /* Allow scrolling if content is tall */
    }

    .login-card {
        width: 100%;
        max-width: 500px;
        border: none;
        margin: 20px; /* Add margin for mobile scrolling */
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
    .btn-outline-primary:hover, .form-check-input:checked + .btn-outline-primary {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
</style>

<script>
    function toggleNimField() {
        if (document.getElementById('type_active').checked) {
            document.getElementById('nim_field').classList.remove('d-none');
        } else {
            document.getElementById('nim_field').classList.add('d-none');
        }
    }
</script>
@endsection
