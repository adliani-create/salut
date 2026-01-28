@extends('layouts.student')

@section('content')
@php
    $program = optional($user->registration)->fokus_karir ?? 'Umum';
    
    // Theme Logic based on Program
    $bannerClass = 'bg-primary';
    $bannerImage = 'https://source.unsplash.com/random/1200x400/?office'; // Fallback
    $motivationalText = "Tingkatkan skillmu dan raih masa depan gemilang!";

    if(str_contains($program, 'Wirausaha')) {
        $bannerClass = 'bg-success'; // Green for Business
        $bannerImage = 'https://source.unsplash.com/random/1200x400/?business,startup';
        $motivationalText = "Siap memulai dan mengembangkan bisnismu hari ini?";
    } elseif(str_contains($program, 'Magang')) {
        $bannerClass = 'bg-info'; // Blue for Internship
        $bannerImage = 'https://source.unsplash.com/random/1200x400/?corporate,working';
        $motivationalText = "Persiapkan dirimu untuk pengalaman kerja profesional!";
    } elseif(str_contains($program, 'Skill')) {
        $bannerClass = 'bg-danger'; // Red for Skill
        $bannerImage = 'https://source.unsplash.com/random/1200x400/?coding,technology';
        $motivationalText = "Asah skill teknis dan jadilah ahli di bidangmu!";
    } elseif(str_contains($program, 'Creator')) {
        $bannerClass = 'bg-warning'; // Yellow for Creator
        $bannerImage = 'https://source.unsplash.com/random/1200x400/?socialmedia,content';
        $motivationalText = "Dunia digital menunggumu. Ayo buat konten viral!";
    }
@endphp

<!-- Hero Banner -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 position-relative text-white">
    <!-- Background Overlay -->
    <div class="position-absolute align-top w-100 h-100 {{ $bannerClass }}" style="opacity: 0.9; mix-blend-mode: multiply;"></div>
    <!-- Actual Image (Using inline style for dynamic url if we had one, for now utilizing gradients/colors more) -->
    <img src="{{ $bannerImage }}" class="position-absolute w-100 h-100 object-fit-cover" style="z-index: -1;" alt="Banner">
    
    <div class="card-body p-5 position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white bg-opacity-25 border border-white border-opacity-50 backdrop-blur mb-3 px-3 py-2 rounded-pill">
                    <i class="bi bi-mortarboard-fill me-2"></i> {{ $program }}
                </span>
                <h1 class="display-5 fw-bold mb-3">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
                <p class="fs-5 opacity-90 mb-4">{{ $motivationalText }}</p>
                @if($program != 'Umum')
                    <button class="btn btn-light rounded-pill px-4 fw-bold text-{{ str_replace('bg-', '', $bannerClass) }}">
                        Lanjutkan Belajar <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                @endif
            </div>
            <div class="col-lg-4 d-none d-lg-block text-end">
                <!-- Abstract or Illustration could go here -->
                <i class="bi bi-trophy-fill text-white opacity-25" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-5">
    <!-- Main Content -->
    <div class="col-lg-8">
        
        <!-- LMS Section with Tabs -->
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0"><i class="bi bi-book-half me-2 text-primary"></i>Materi Belajar (LMS)</h4>
                
                <!-- Tab Navigation -->
                <ul class="nav nav-pills bg-light p-1 rounded-pill" id="lmsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill px-3 small fw-bold" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">Semua</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-3 small fw-bold" id="video-tab" data-bs-toggle="tab" data-bs-target="#video" type="button" role="tab">Video</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-3 small fw-bold" id="ebook-tab" data-bs-toggle="tab" data-bs-target="#ebook" type="button" role="tab">E-Book</button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="lmsTabContent">
                <!-- ALL Tab -->
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                    @include('mahasiswa.partials.lms-grid', ['items' => $materials])
                </div>
                
                <!-- Video Tab -->
                <div class="tab-pane fade" id="video" role="tabpanel">
                    @include('mahasiswa.partials.lms-grid', ['items' => $materials->where('type', 'video')])
                </div>

                <!-- Ebook Tab -->
                <div class="tab-pane fade" id="ebook" role="tabpanel">
                    @include('mahasiswa.partials.lms-grid', ['items' => $materials->where('type', 'ebook')])
                </div>
            </div>
        </div>

        <!-- Training Schedule -->
        <div class="mb-5">
            <h4 class="fw-bold mb-4"><i class="bi bi-calendar-week me-2 text-info"></i>Jadwal Pelatihan</h4>
            
            @forelse($trainings as $training)
                <div class="card border-0 shadow-sm hover-up transition-base mb-3 rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Date Box -->
                            <div class="col-md-2 bg-light d-flex flex-column align-items-center justify-content-center border-end p-3 text-center">
                                <span class="h2 fw-bold text-primary mb-0">{{ \Carbon\Carbon::parse($training->date)->format('d') }}</span>
                                <span class="text-uppercase small fw-bold text-muted">{{ \Carbon\Carbon::parse($training->date)->format('M') }}</span>
                            </div>
                            
                            <!-- Content -->
                            <div class="col-md-7 p-3">
                                <h5 class="fw-bold mb-1">{{ $training->title }}</h5>
                                <div class="mb-2">
                                     <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill me-2">
                                        <i class="bi bi-clock me-1"></i> {{ $training->time }}
                                    </span>
                                    <span class="text-muted small"><i class="bi bi-geo-alt me-1"></i> {{ $training->location }}</span>
                                </div>
                                <p class="mb-0 text-muted small line-clamp-2">{{ Str::limit($training->description, 100) }}</p>
                            </div>

                            <!-- Action -->
                            <div class="col-md-3 p-3 d-flex align-items-center justify-content-center">
                                <button class="btn btn-outline-primary rounded-pill fw-bold w-100" data-bs-toggle="modal" data-bs-target="#trainingModal{{ $training->id }}">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Modal -->
                <div class="modal fade" id="trainingModal{{ $training->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content overflow-hidden rounded-4 border-0">
                            <div class="row g-0">
                                <!-- Left: Poster -->
                                <div class="col-md-5 bg-dark d-flex align-items-center justify-content-center">
                                    @if($training->poster)
                                        <img src="{{ asset('storage/' . $training->poster) }}" class="w-100 h-100 object-fit-cover" style="min-height: 400px;" alt="{{ $training->title }}">
                                    @else
                                        <div class="text-center text-white opacity-50 p-5">
                                            <i class="bi bi-image fs-1 mb-3"></i>
                                            <p class="small">Poster belum tersedia</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Right: Info -->
                                <div class="col-md-7">
                                    <div class="modal-header border-0 pb-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 pt-2">
                                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2 rounded-pill px-3">Webinar</span>
                                        <h4 class="fw-bold mb-3">{{ $training->title }}</h4>
                                        
                                        <div class="mb-4">
                                            <div class="d-flex align-items-center mb-2 text-muted">
                                                <i class="bi bi-person-circle me-3 fs-5 text-primary"></i>
                                                <div>
                                                    <small class="d-block fw-bold text-dark">Pembicara</small>
                                                    <span>{{ $training->instructor ?? 'TBA' }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-2 text-muted">
                                                <i class="bi bi-calendar-event me-3 fs-5 text-primary"></i>
                                                <div>
                                                    <small class="d-block fw-bold text-dark">Waktu</small>
                                                    <span>{{ \Carbon\Carbon::parse($training->date)->format('d M Y') }}, {{ $training->time }} WIB</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="bi bi-geo-alt me-3 fs-5 text-danger"></i>
                                                <div>
                                                    <small class="d-block fw-bold text-dark">Tempat</small>
                                                    <span>{{ $training->location }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="text-muted small mb-4" style="line-height: 1.6;">
                                            {{ $training->description }}
                                        </p>

                                        <div class="d-grid">
                                            @if($training->link)
                                                <a href="{{ $training->link }}" target="_blank" class="btn btn-primary rounded-pill fw-bold py-2">
                                                    Daftar Sekarang <i class="bi bi-arrow-right-short fs-5 align-middle"></i>
                                                </a>
                                            @else
                                                <button class="btn btn-secondary rounded-pill fw-bold py-2" disabled>Link Belum Tersedia</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center p-5 bg-white border border-dashed rounded-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                         <i class="bi bi-play-btn-fill fs-1 text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-muted">Belum ada jadwal pelatihan saat ini.</h5>
                    <p class="text-muted small mb-3">Yuk, tonton materi video yang ada untuk menambah skill kamu hari ini!</p>
                    <button class="btn btn-primary rounded-pill btn-sm px-4" onclick="document.getElementById('video-tab').click(); document.getElementById('lmsTab').scrollIntoView({behavior: 'smooth'})">
                        <i class="bi bi-play-circle me-1"></i> Lihat Materi Video
                    </button>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Sidebar Widget (Gamification) -->
    <div class="col-lg-4">
        <!-- Progress Widget -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-award me-2 text-warning"></i>Pencapaian Saya</h5>
                
                <div class="d-flex align-items-center mb-3">
                     <div class="progress flex-grow-1" style="height: 10px; border-radius: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="ms-3 fw-bold small">35%</span>
                </div>
                <p class="small text-muted mb-4">Selesaikan 2 materi lagi untuk mendapatkan badge "Starter"!</p>

                <div class="row g-2 text-center">
                    <!-- Badges -->
                    <div class="col-4">
                        <div class="p-3 bg-light rounded-3 opacity-50" tabindex="0" data-bs-toggle="tooltip" title="Selesaikan 5 Materi">
                             <i class="bi bi-star-fill fs-2 text-secondary"></i>
                             <div class="small fw-bold mt-1 text-muted" style="font-size: 10px;">Starter</div>
                        </div>
                    </div>
                    <div class="col-4">
                         <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded-3" tabindex="0" data-bs-toggle="tooltip" title="Login 7 Hari Berturut-turut">
                             <i class="bi bi-fire fs-2 text-warning"></i>
                             <div class="small fw-bold mt-1 text-warning" style="font-size: 10px;">On Fire!</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-light rounded-3 opacity-50" tabindex="0" data-bs-toggle="tooltip" title="Kumpulkan 100 Poin">
                             <i class="bi bi-trophy-fill fs-2 text-secondary"></i>
                             <div class="small fw-bold mt-1 text-muted" style="font-size: 10px;">Master</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .backdrop-blur { backdrop-filter: blur(5px); }
    .object-fit-cover { object-fit: cover; }
    .hover-up:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .transition-base { transition: all 0.3s ease; }
    .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
</style>

@endsection
