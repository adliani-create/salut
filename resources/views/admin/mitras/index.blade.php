@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0 text-gray-800">Manajemen Mitra</h2>
            <p class="text-muted mb-0">Kelola master data mitra, lihat jaringan afiliasi, dan pantau performa.</p>
        </div>
        <a href="{{ route('admin.mitras.create') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-lg me-1"></i> Tambah Mitra Baru
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Nama Mitra / PIC</th>
                            <th class="py-3">Kode Referral</th>
                            <th class="py-3">Kontak</th>
                            <th class="py-3 text-center">Tim Afiliasi</th>
                            <th class="py-3 text-center">Total Poin</th>
                            <th class="py-3">Status</th>
                            <th class="pe-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mitras as $mitra)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                        {{ substr($mitra->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $mitra->name }}</h6>
                                        <small class="text-muted">{{ optional($mitra->mitraProfile)->company_name ?? 'Perorangan' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-dark bg-opacity-10 text-dark font-monospace fs-6 px-3 py-2">
                                    {{ $mitra->referral_code ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div><i class="bi bi-envelope text-muted"></i> {{ $mitra->email }}</div>
                                <div><i class="bi bi-whatsapp text-success"></i> {{ $mitra->whatsapp ?? '-' }}</div>
                            </td>
                            <td class="py-3 text-center">
                                <span class="fw-bold fs-5">{{ $mitra->referrals()->count() }}</span>
                            </td>
                            <td class="py-3 text-center">
                                <span class="fw-bold text-primary fs-5">{{ number_format($mitra->total_points, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3">
                                @if($mitra->status === 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2"><i class="bi bi-clock-history me-1"></i>Pending</span>
                                @elseif($mitra->status === 'active')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">Aktif</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">Suspended</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex gap-1 justify-content-end flex-wrap">
                                    @if($mitra->status === 'pending')
                                        <form action="{{ route('admin.mitras.approve', $mitra) }}" method="POST" class="d-inline" onsubmit="return confirm('Setujui pendaftaran mitra ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve Mitra">
                                                <i class="bi bi-check-lg me-1"></i> Approve
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.mitras.show', $mitra) }}" class="btn btn-sm btn-info text-white" title="Review Data">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.mitras.edit', $mitra) }}" class="btn btn-sm btn-warning" title="Edit Profil">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($mitra->status !== 'pending')
                                    <form action="{{ route('admin.mitras.destroy', $mitra) }}" method="POST" onsubmit="return confirm('Suspend mitra ini?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Suspend Mitra">
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
                                <i class="bi bi-people fs-1 d-block mb-3"></i>
                                Belum ada data Mitra.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($mitras->hasPages())
            <div class="card-footer bg-white border-top py-3">
                {{ $mitras->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
