@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold m-0 text-dark">Manajemen Akademik</h3>
            <p class="text-muted small m-0">Pantau dan kelola progress akademik mahasiswa.</p>
        </div>
        <div>
            <form action="{{ route('admin.academic.index') }}" method="GET" class="d-flex">
                <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white" style="width: 450px;">
                    <span class="input-group-text bg-white border-0 ps-3 pe-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control border-0 ps-2" placeholder="Cari Nama atau NIM Mahasiswa..." value="{{ $search }}">
                    <button class="btn btn-primary px-4 fw-bold" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Student Cards -->
    <div class="row g-3">
        @forelse($students as $student)
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-hover-effect">
                <div class="card-body p-3">
                    <div class="row align-items-center g-3">
                        
                        <!-- 1. Info Mahasiswa -->
                        <div class="col-md-3 d-flex align-items-center border-end-md">
                            <div class="avatar-placeholder bg-light text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3 shadow-sm" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                @if($student->photo)
                                    <img src="{{ asset('storage/'.$student->photo) }}" class="w-100 h-100 rounded-circle object-fit-cover" alt="{{ $student->name }}">
                                @else
                                    <span class="fw-bold">{{ strtoupper(substr($student->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <h6 class="fw-bold mb-0 text-truncate" title="{{ $student->name }}">{{ $student->name }}</h6>
                                <div class="text-muted fw-bold small">{{ $student->nim ?? 'No NIM' }}</div>
                            </div>
                        </div>

                        <!-- 2. Progress Transkrip (Timeline 1-8) -->
                        <div class="col-md-5">
                            <div class="d-flex align-items-center justify-content-start flex-wrap gap-2">
                                <span class="text-muted small fw-bold me-2">Progress:</span>
                                @for($i = 1; $i <= 8; $i++)
                                    @php
                                        // Check if record exists for this semester (assuming exact match "1", "2" or maybe check if we should be lenient)
                                        // For now, checking strict match against stored semester string.
                                        $hasRecord = $student->academicRecords->contains('semester', (string)$i);
                                    @endphp
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="badge rounded-pill d-flex align-items-center justify-content-center shadow-sm {{ $hasRecord ? 'bg-success' : 'bg-secondary bg-opacity-10 text-muted' }}" 
                                              style="width: 28px; height: 28px; font-size: 0.75rem; transition: all 0.2s;">
                                            {{ $i }}
                                        </span>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- 3. Aksi -->
                        <div class="col-md-4 text-end">
                            <div class="d-inline-flex gap-2">
                                <!-- Upload Transkrip (Blue Outline) -->
                                <a href="{{ route('admin.academic.upload', $student->id) }}" class="btn btn-outline-primary rounded-pill px-3 fw-bold btn-sm d-flex align-items-center">
                                    <i class="bi bi-upload me-2"></i> Upload Transkrip
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 py-5 text-center text-muted">
            <div class="mb-3"><i class="bi bi-emoji-frown fs-1 opacity-50"></i></div>
            <p>Belum ada mahasiswa ditemukan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $students->links('vendor.pagination.custom') }}
    </div>
</div>

<style>
    .card-hover-effect { transition: transform 0.2s, box-shadow 0.2s; }
    .card-hover-effect:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.05)!important; }
    @media (min-width: 768px) { .border-end-md { border-right: 1px solid #dee2e6; } }
</style>
@endsection
