@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-5">Choose Your Non-Academic Track</h2>
    
    <form action="{{ route('student.enrollment.storeStep2') }}" method="POST">
        @csrf
        <div class="row g-4 justify-content-center">
            <!-- Track 1: Magang -->
            <div class="col-md-5 col-lg-3">
                <input type="radio" class="btn-check" name="track_name" id="track_magang" value="Magang" required>
                <label class="card h-100 border-0 shadow-sm cursor-pointer track-card" for="track_magang">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary mb-3 mx-auto">
                            <i class="bi bi-briefcase fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Magang</h5>
                        <p class="small text-muted">Gain real-world experience with our industry partners.</p>
                    </div>
                </label>
            </div>

            <!-- Track 2: Skill Academy -->
            <div class="col-md-5 col-lg-3">
                <input type="radio" class="btn-check" name="track_name" id="track_skill" value="Skill Academy">
                <label class="card h-100 border-0 shadow-sm cursor-pointer track-card" for="track_skill">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-success bg-opacity-10 text-success mb-3 mx-auto">
                            <i class="bi bi-laptop fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Skill Academy</h5>
                        <p class="small text-muted">Intensive courses to master specific industry skills.</p>
                    </div>
                </label>
            </div>

            <!-- Track 3: Affiliator/Creator -->
            <div class="col-md-5 col-lg-3">
                <input type="radio" class="btn-check" name="track_name" id="track_affiliate" value="Affiliator">
                <label class="card h-100 border-0 shadow-sm cursor-pointer track-card" for="track_affiliate">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-warning bg-opacity-10 text-warning mb-3 mx-auto">
                            <i class="bi bi-megaphone fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Affiliator / Creator</h5>
                        <p class="small text-muted">Learn digital marketing and content creation.</p>
                    </div>
                </label>
            </div>

            <!-- Track 4: Wirausaha -->
            <div class="col-md-5 col-lg-3">
                <input type="radio" class="btn-check" name="track_name" id="track_entrepreneur" value="Wirausaha">
                <label class="card h-100 border-0 shadow-sm cursor-pointer track-card" for="track_entrepreneur">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-danger bg-opacity-10 text-danger mb-3 mx-auto">
                            <i class="bi bi-shop fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Wirausaha</h5>
                        <p class="small text-muted">Build and grow your own business.</p>
                    </div>
                </label>
            </div>
        </div>

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm">
                Confirm Selection <i class="bi bi-check-lg ms-2"></i>
            </button>
        </div>
    </form>
    
    <div class="text-center mt-4 text-muted small">
        Step 2 of 3: Program Selection
    </div>
</div>

<style>
    .track-card {
        transition: all 0.3s ease;
    }
    .btn-check:checked + .track-card {
        box-shadow: 0 0 0 2px #0d6efd, 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-5px);
    }
    .track-card:hover {
        transform: translateY(-5px);
    }
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
