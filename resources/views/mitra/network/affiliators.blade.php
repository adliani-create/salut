@extends('layouts.mitra')

@section('title', 'Tim Affiliator Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Daftar Affiliator yang terdaftar menggunakan kode referral Anda.</p>
    </div>
    <form action="{{ route('mitra.network.affiliators') }}" method="GET" class="d-flex" style="width: 280px;">
        <div class="input-group">
            <input type="text" name="search" class="form-control rounded-start-pill border-0" placeholder="Cari nama, kontak..." value="{{ $search }}">
            <button class="btn btn-primary rounded-end-pill px-3" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Nama Affiliator</th>
                        <th class="py-3">Info Kontak</th>
                        <th class="py-3">Tanggal Terdaftar</th>

                        <th class="pe-4 py-3 text-center">Status</th>
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
                                    <small class="badge bg-light text-dark font-monospace border mt-1">{{ $affiliator->referral_code }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <small class="d-block"><i class="bi bi-envelope text-muted me-1"></i>{{ $affiliator->email }}</small>
                            <small class="d-block text-success fw-bold"><i class="bi bi-whatsapp me-1"></i>{{ $affiliator->whatsapp ?? '-' }}</small>
                        </td>
                        <td class="py-3">
                            {{ $affiliator->created_at->translatedFormat('d F Y') }}
                        </td>

                        <td class="pe-4 py-3 text-center">
                            @if($affiliator->status === 'active')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Aktif</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i> Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-diagram-3 fs-1 opacity-25 d-block mb-3"></i>
                            Anda belum memiliki anggota tim Affiliator.<br>
                            Sebarkan link rujukan Anda sekarang!
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
@endsection
