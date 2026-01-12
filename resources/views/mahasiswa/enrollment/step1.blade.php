@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="bi bi-person-check-fill text-primary display-1"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Welcome, {{ Auth::user()->name }}!</h2>
                    <p class="text-muted mb-4 lead">You have successfully created your account. Let's complete your enrollment profile.</p>
                    
                    <div class="alert alert-info border-0 rounded-3 text-start">
                        <i class="bi bi-info-circle me-2"></i> Only a few more steps to unlock your student dashboard.
                    </div>

                    <form action="{{ route('student.enrollment.storeStep1') }}" method="POST">
                        @csrf
                        {{-- Add specific profile fields if needed, for now just confirmation --}}
                        <div class="d-grid gap-2 col-md-6 mx-auto mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                                Continue to Program Selection <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3 text-muted small">
                Step 1 of 3: Account Verification
            </div>
        </div>
    </div>
</div>
@endsection
