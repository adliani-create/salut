@extends('layouts.student')

@section('content')
<div class="container py-4">
    
    <!-- Profile Display Section -->
    <div class="row g-4 mb-5">
        <!-- Left Panel: Identity Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden text-center bg-white">
                <div class="card-body p-5 d-flex flex-column align-items-center justify-content-center">
                    
                    <!-- Avatar -->
                    <div class="mb-4 position-relative">
                        <div class="avatar-placeholder rounded-circle shadow-sm overflow-hidden d-flex align-items-center justify-content-center bg-light text-primary" 
                             style="width: 140px; height: 140px; font-size: 3rem;">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" class="w-100 h-100 object-fit-cover" alt="{{ $user->name }}">
                            @else
                                <span class="fw-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            @endif
                        </div>
                        <div class="position-absolute bottom-0 end-0 bg-success border border-4 border-white rounded-circle p-2" 
                             style="width: 32px; height: 32px;" title="Aktif"></div>
                    </div>

                    <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                    <div class="text-muted fw-bold mb-3">{{ $user->nim ?? 'NIM: -' }}</div>
                    
                    <div class="badge bg-light text-muted border px-3 py-2 rounded-pill mb-4 w-100 text-truncate">
                        <i class="bi bi-envelope me-2"></i> {{ $user->email }}
                    </div>

                    <div class="alert alert-success border-0 w-100 fw-bold py-2 mb-0 rounded-pill">
                        <i class="bi bi-check-circle-fill me-2"></i> Status: Aktif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel: Academic Data -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white pt-4 pb-0 border-0 ps-4">
                    <h5 class="fw-bold text-primary mb-0"><i class="bi bi-mortarboard-fill me-2"></i>Data Akademik</h5>
                </div>
                <div class="card-body p-4">
                    
                    <div class="row g-4">
                        <!-- IPK Widget -->
                        <div class="col-12">
                            <div class="bg-primary bg-opacity-10 rounded-4 p-4 d-flex align-items-center justify-content-between border border-primary border-opacity-10 position-relative overflow-hidden">
                                <div class="position-relative z-1">
                                    <small class="text-primary fw-bold text-uppercase ls-1">IPK Saat Ini</small>
                                    <h1 class="display-3 fw-bold text-primary mb-1 mt-1">{{ number_format($user->ipk ?? 3.50, 2) }}</h1>
                                    
                                    <!-- Progress Bar -->
                                    <div class="progress mt-2" style="height: 6px; width: 150px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ (($user->ipk ?? 3.50) / 4) * 100 }}%" aria-valuenow="{{ $user->ipk ?? 3.50 }}" aria-valuemin="0" aria-valuemax="4"></div>
                                    </div>
                                    <small class="text-muted mt-2 d-block">Skala 4.00</small>
                                </div>
                                <div class="position-absolute end-0 bottom-0 opacity-25 pe-4 pb-2">
                                    <i class="bi bi-bar-chart-fill" style="font-size: 5rem; color: var(--bs-primary);"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-4 h-100">
                                <small class="text-muted d-block mb-1 text-uppercase" style="font-size: 0.75rem;">Fakultas</small>
                                <div class="fw-bold text-dark fs-5">{{ $user->faculty ?? $user->registration->fakultas ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-4 h-100">
                                <small class="text-muted d-block mb-1 text-uppercase" style="font-size: 0.75rem;">Jurusan / Prodi</small>
                                <div class="fw-bold text-dark fs-5">{{ $user->major ?? $user->registration->prodi ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 border rounded-4 text-center h-100">
                                <small class="text-muted d-block mb-1 text-uppercase" style="font-size: 0.75rem;">Jenjang</small>
                                <div class="fw-bold text-dark fs-5">{{ $user->registration->jenjang ?? 'S1' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-4 text-center h-100">
                                <small class="text-muted d-block mb-1 text-uppercase" style="font-size: 0.75rem;">Angkatan</small>
                                <div class="fw-bold text-dark fs-5">{{ $user->angkatan ?? '2021' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-4 text-center h-100">
                                <small class="text-muted d-block mb-1 text-uppercase" style="font-size: 0.75rem;">Jalur Masuk</small>
                                <div class="badge bg-info text-dark rounded-pill mt-1">{{ $user->registration->jalur_pendaftaran ?? 'Reguler' }}</div>
                            </div>
                        </div>

                        <!-- Semester Large Display -->
                        <div class="col-12 text-center text-muted">
                            <hr class="my-0">
                            <div class="mt-3">
                                <span class="badge bg-white text-secondary border px-4 py-2 rounded-pill fs-6 shadow-sm">
                                    Semester <span class="fw-bold text-dark">{{ $user->semester ?? 1 }}</span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Link -->
    <div class="card border-0 shadow-sm rounded-4 cursor-pointer hover-shadow transition-all" onclick="window.location='{{ route('profile.edit') }}'">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-light text-primary rounded-circle p-3 me-3">
                    <i class="bi bi-gear-fill fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark">Pengaturan Akun & Edit Profil</h6>
                    <small class="text-muted">Ganti foto profil, nama, atau password.</small>
                </div>
            </div>
            <i class="bi bi-chevron-right text-muted"></i>
        </div>
    </div>

</div>

<style>
    .hover-shadow:hover { box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; transform: translateY(-2px); transition: all 0.2s; }
</style>
@endsection
