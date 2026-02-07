@extends('layouts.admin')

@section('title', 'LMS & Non-Akademik')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-2 text-gray-800">Manajemen Non-Akademik</h1>
            <p class="mb-4 text-muted">Kelola program unggulan, materi pembelajaran, dan jadwal pelatihan mahasiswa.</p>
        </div>
    </div>

    <!-- Management Modules Cards -->
    <div class="row g-4 mb-5">
        <!-- Master Program -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2 hover-scale">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Setup Awal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Master Program</div>
                            <p class="text-muted small mt-2 mb-0">Kelola kategori program (Kuliah + Magang, Wirausaha, dll).</p>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-grid-fill fa-2x text-gray-300 fs-1 text-primary bg-primary bg-opacity-10 p-3 rounded"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.career-programs.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Materi Pembelajaran -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-left-success shadow h-100 py-2 hover-scale">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Content Management</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Materi Pembelajaran</div>
                            <p class="text-muted small mt-2 mb-0">Upload video & modul PDF untuk mahasiswa.</p>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-collection-play-fill fa-2x text-gray-300 fs-1 text-success bg-success bg-opacity-10 p-3 rounded"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.lms-materials.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Jadwal Pelatihan -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-left-info shadow h-100 py-2 hover-scale">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Event & Webinar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Jadwal Pelatihan</div>
                            <p class="text-muted small mt-2 mb-0">Buat jadwal webinar dan mentoring.</p>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-event-fill fa-2x text-gray-300 fs-1 text-info bg-info bg-opacity-10 p-3 rounded"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.trainings.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Monitoring Section -->
    <div class="row mb-3">
        <div class="col-12">
             <h4 class="font-weight-bold text-gray-800 border-bottom pb-2 mb-3">Monitoring Peserta Program</h4>
        </div>
    </div>

    <div class="row g-4">
        @foreach($stats as $stat)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $stat['color'] }} text-uppercase mb-1">
                                {{ $stat['name'] }}
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $stat['count'] }} <small class="text-muted fs-6">Mhs</small></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi {{ $stat['icon'] }} fs-2 text-{{ $stat['color'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: translateY(-5px); }
</style>
@endsection
