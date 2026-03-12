@extends('layouts.student')

@section('title', 'Agenda & Jadwal Terdekat')

@section('content')
<div class="container-fluid py-4 min-vh-100">
    <div class="row mb-4">
        <div class="col-12 text-center text-md-start">
            <h2 class="fw-bold text-dark mb-1">Agenda & Jadwal Akademik</h2>
            <p class="text-muted">Daftar jadwal kegiatan belajar dan ujian yang akan datang.</p>
        </div>
    </div>

    <!-- Agenda Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-calendar-event me-2 text-primary"></i>Jadwal Terdekat
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-muted small text-uppercase">Tanggal & Waktu</th>
                            <th class="py-3 text-muted small text-uppercase">Jenis</th>
                            <th class="py-3 text-muted small text-uppercase mb-0">Judul Agenda</th>
                            <th class="pe-4 py-3 text-muted small text-uppercase text-end">Batas Waktu (Tenggat)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($academicSchedules as $schedule)
                            @php
                                $badgeColor = 'secondary';
                                if($schedule->type == 'tugas') $badgeColor = 'danger';
                                if($schedule->type == 'diskusi') $badgeColor = 'warning text-dark';
                                if($schedule->type == 'tuweb') $badgeColor = 'primary';
                                if($schedule->type == 'ujian') $badgeColor = 'danger';
                            @endphp
                            <tr class="border-bottom">
                                <td class="ps-4 py-3">
                                    <span class="d-block fw-bold text-dark">{{ $schedule->date->format('d M Y') }}</span>
                                    <span class="small text-muted"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-{{ $badgeColor }} text-uppercase px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.75rem;">
                                        {{ $schedule->type }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $schedule->title }}</div>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    @if($schedule->deadline)
                                        <div class="text-danger small fw-bold bg-danger bg-opacity-10 d-inline-block px-3 py-2 rounded-pill">
                                            <i class="bi bi-exclamation-circle me-1"></i> {{ $schedule->deadline->format('d M Y, H:i') }}
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-check fs-1 d-block mb-3 text-opacity-50 text-success"></i>
                                    <span class="d-block">Tidak ada agenda akademik dalam waktu dekat.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
