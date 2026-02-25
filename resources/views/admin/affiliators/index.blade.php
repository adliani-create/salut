@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0 text-gray-800">Manajemen Affiliator</h2>
            <p class="text-muted mb-0">Kelola master data Affiliator dan struktur jaringannya.</p>
        </div>
        <div>
            <!-- Affiliator registers via referral link, but Admin could potentially force-add one from DB or custom page. -->
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm rounded-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill me-2 text-primary"></i>Daftar Affiliator</h6>
            
            <form action="{{ route('admin.affiliators.index') }}" method="GET" class="d-flex" style="width: 300px;">
                <div class="input-group">
                    <input type="text" name="search" class="form-control rounded-start-pill bg-light border-0" placeholder="Cari nama, email, kode..." value="{{ $search }}">
                    <button class="btn btn-primary rounded-end-pill px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Affiliator</th>
                            <th class="py-3">Upline (Mitra)</th>
                            <th class="py-3">Kode Referral</th>
                            <th class="py-3 text-center">Total Perekrutan</th>
                            <th class="py-3 text-end">Total Poin</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="pe-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($affiliators as $affiliator)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                        {{ substr($affiliator->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $affiliator->name }}</h6>
                                        <small class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $affiliator->email }}</small><br>
                                        <small class="text-success"><i class="bi bi-whatsapp me-1"></i>{{ $affiliator->whatsapp ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($affiliator->referrer)
                                    <span class="d-block fw-bold">{{ $affiliator->referrer->name }}</span>
                                    <small class="text-primary">{{ $affiliator->referrer->referral_code }}</small>
                                @else
                                    <span class="text-muted fst-italic">Independen (Tanpa Mitra)</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="badge bg-dark bg-opacity-10 text-dark font-monospace fs-6 px-3 py-2">
                                    {{ $affiliator->referral_code ?? 'Belum Ada' }}
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge bg-info rounded-pill px-3 py-2">{{ $affiliator->students_count }} Maba</span>
                            </td>
                            <td class="py-3 text-end">
                                <span class="fw-bold fs-5 text-success">{{ number_format($affiliator->total_points, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3 text-center">
                                @if($affiliator->status === 'active')
                                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Aktif</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i> Dibekukan</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-center">
                                <div class="btn-group shadow-sm rounded-pill" role="group">
                                    <a href="{{ route('admin.affiliators.show', $affiliator) }}" class="btn btn-sm btn-light border" data-bs-toggle="tooltip" title="Lihat Rekrutmen">
                                        <i class="bi bi-diagram-2 text-primary"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.affiliators.edit', $affiliator) }}" class="btn btn-sm btn-light border" data-bs-toggle="tooltip" title="Edit Data">
                                        <i class="bi bi-pencil-square text-secondary"></i>
                                    </a>
                                    @if($affiliator->status === 'active')
                                    <form action="{{ route('admin.affiliators.destroy', $affiliator) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin MEMBEKUKAN Affiliator ini? Akun ini tidak akan bisa digunakan secara langsung oleh pengguna.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border text-danger" data-bs-toggle="tooltip" title="Suspend Akun">
                                            <i class="bi bi-slash-circle"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-1 d-block mb-3 opacity-50"></i>
                                Tidak ada data affiliator ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($affiliators->hasPages())
            <div class="card-footer bg-white border-top py-3">
                {{ $affiliators->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
