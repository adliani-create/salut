@extends('layouts.affiliator')

@section('title', 'Daftar Mahasiswa')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-4 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-1 text-dark"><i class="bi bi-list-check text-primary me-2"></i>Pemantauan & Pergerakan Status Mahasiswa</h5>
            <p class="text-muted small mb-0">Daftar ini adalah gabungan prospek input manual dan pendaftar via link Anda.</p>
        </div>
        <a href="{{ route('affiliator.students.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
            <i class="bi bi-plus-circle me-2"></i>Input Prospek Baru
        </a>
    </div>

    @if(session('success'))
        <div class="px-4">
            <div class="alert alert-success alert-dismissible fade show rounded-3 py-2" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="card-body p-0">
        <!-- DESKTOP VIEW: Table -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Sumber Data</th>
                        <th class="py-3">Info Calon Mahasiswa</th>
                        <th class="py-3">Waktu Input</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="pe-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td class="ps-4">
                            @if($student->source === 'manual')
                                <span class="badge bg-warning text-dark"><i class="bi bi-pencil-square me-1"></i>Input Manual</span>
                            @else
                                <span class="badge bg-info text-white"><i class="bi bi-link-45deg me-1"></i>Via Link</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <strong class="d-block text-dark">{{ $student->name }}</strong>
                                    <span class="d-block small mt-1">
                                        <i class="bi bi-whatsapp text-success me-1"></i>{{ $student->whatsapp }}
                                    </span>
                                    <span class="d-block small text-muted">Minat: {{ $student->program }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="d-block fw-bold text-dark">{{ \Carbon\Carbon::parse($student->created_at)->translatedFormat('d F Y') }}</span>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($student->created_at)->format('H:i') }} WIB</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $student->status_color }} rounded-pill px-3 py-2 fs-6">
                                @if($student->status_label === 'PROSPEK')
                                    <i class="bi bi-hourglass-top me-1"></i> PROSPEK
                                @elseif($student->status_label === 'TERDAFTAR')
                                    <i class="bi bi-file-earmark-check me-1"></i> TERDAFTAR
                                @else
                                    <i class="bi bi-check-circle-fill me-1"></i> BAYAR (Aktif)
                                @endif
                            </span>
                        </td>
                        <td class="pe-4 text-center">
                            @php
                                $waNumber = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $student->whatsapp));
                                $affName = Auth::user()->name;
                                $refLink = url('/register?ref=' . Auth::user()->referral_code);
                                
                                if($student->status_label === 'PROSPEK') {
                                    $waText = urlencode("Halo {$student->name}, saya {$affName}. Berikut adalah link pendaftaran resmi kampus untuk Anda:\n\n{$refLink}");
                                } else {
                                    $waText = urlencode("Halo {$student->name}, saya {$affName}. Kami melihat Anda sudah mulai mendaftar. Mohon segera selesaikan registrasi akun dan tagihan pembayaran Anda supaya bisa mulai kuliah & mengakses materi!");
                                }
                            @endphp

                            @if($student->status_label !== 'BAYAR (Aktif)')
                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-whatsapp me-1"></i> Follow Up
                                </a>
                            @else
                                <span class="badge bg-light text-success border border-success"><i class="bi bi-check-all me-1"></i> Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-person-x fs-1 opacity-25 d-block mb-3"></i>
                            Belum ada satupun Mahasiswa/Prospek terdata.<br>
                            Mulai sebar link referral Anda atau catat nama prospek secara manual sekarang!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE VIEW: Cards -->
        <div class="d-block d-md-none p-3">
            @forelse($students as $student)
            <div class="card shadow-sm border-0 mb-3 rounded-4">
                <div class="card-body">
                    <!-- Top section: Source and Status -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            @if($student->source === 'manual')
                                <span class="badge bg-warning text-dark"><i class="bi bi-pencil-square me-1"></i>Input Manual</span>
                            @else
                                <span class="badge bg-info text-white"><i class="bi bi-link-45deg me-1"></i>Via Link</span>
                            @endif
                        </div>
                        <span class="badge bg-{{ $student->status_color }} rounded-pill px-3 py-1">
                            @if($student->status_label === 'PROSPEK')
                                <i class="bi bi-hourglass-top me-1"></i> PROSPEK
                            @elseif($student->status_label === 'TERDAFTAR')
                                <i class="bi bi-file-earmark-check me-1"></i> TERDAFTAR
                            @else
                                <i class="bi bi-check-circle-fill me-1"></i> BAYAR (Aktif)
                            @endif
                        </span>
                    </div>
                    
                    <!-- Middle section: Student Info -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 50px; height: 50px;">
                            {{ substr($student->name, 0, 1) }}
                        </div>
                        <div>
                            <strong class="d-block text-dark fs-5 mb-1">{{ $student->name }}</strong>
                            <div class="small text-muted mb-1"><i class="bi bi-whatsapp text-success me-1"></i>{{ $student->whatsapp }}</div>
                            <div class="small text-muted"><i class="bi bi-book me-1"></i>{{ $student->program }}</div>
                        </div>
                    </div>
                    
                    <!-- Bottom section: Date and Action Button -->
                    <div class="d-flex justify-content-between align-items-end mt-3 border-top pt-3">
                        <div>
                            <small class="d-block text-muted mb-1">Didaftarkan pada:</small>
                            <span class="fw-bold d-block" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($student->created_at)->translatedFormat('d M Y') }}</span>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($student->created_at)->format('H:i') }} WIB</small>
                        </div>
                        <div>
                            @php
                                $waNumber = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $student->whatsapp));
                                $affName = Auth::user()->name;
                                $refLink = url('/register?ref=' . Auth::user()->referral_code);
                                
                                if($student->status_label === 'PROSPEK') {
                                    $waText = urlencode("Halo {$student->name}, saya {$affName}. Berikut adalah link pendaftaran resmi kampus untuk Anda:\n\n{$refLink}");
                                } else {
                                    $waText = urlencode("Halo {$student->name}, saya {$affName}. Kami melihat Anda sudah mulai mendaftar. Mohon segera selesaikan registrasi akun dan tagihan pembayaran Anda supaya bisa mulai kuliah & mengakses materi!");
                                }
                            @endphp

                            @if($student->status_label !== 'BAYAR (Aktif)')
                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                                    <i class="bi bi-whatsapp me-1"></i> Hubungi
                                </a>
                            @else
                                <span class="badge bg-light text-success border border-success p-2 px-3 fs-6 rounded-pill"><i class="bi bi-check-all me-1"></i> Selesai</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-person-x fs-1 opacity-25 d-block mb-3"></i>
                Belum ada satupun Mahasiswa/Prospek terdata.<br>
                Mulai catat nama prospek secara manual sekarang!
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
