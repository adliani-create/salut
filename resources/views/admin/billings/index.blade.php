@extends('layouts.admin')

@section('title', 'Daftar Tagihan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="text-primary fw-bold mb-1">Daftar Tagihan</h4>
                <div class="text-muted">Kelola tagihan mahasiswa dan status pembayaran.</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.billings.create-bulk') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Generate Massal
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('admin.billings.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Layanan SALUT" {{ request('category') == 'Layanan SALUT' ? 'selected' : '' }}>Layanan SALUT</option>
                            <option value="UKT" {{ request('category') == 'UKT' ? 'selected' : '' }}>UKT</option>
                            <option value="SPI" {{ request('category') == 'SPI' ? 'selected' : '' }}>SPI</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-light border w-100">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Mahasiswa</th>
                                <th>Prodi</th> <!-- Added -->
                                <th>Kategori / Sem</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Tenggat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($billings as $billing)
                            <tr>
                                <td class="small text-muted">{{ $billing->billing_code }}</td>
                                <td>
                                    <div class="fw-bold">{{ $billing->user->name }}</div>
                                    <div class="small text-muted">{{ $billing->user->nim ?? 'NIM: -' }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $billing->user->registration->prodi ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $billing->category }}</div>
                                    <div class="small text-muted">Semester {{ $billing->semester }}</div>
                                </td>
                                <td class="fw-bold">Rp {{ number_format($billing->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if($billing->status == 'paid') <span class="badge bg-success">Lunas</span>
                                    @elseif($billing->status == 'pending') <span class="badge bg-warning text-dark">Verifikasi</span>
                                    @elseif($billing->status == 'failed') <span class="badge bg-danger">Ditolak</span>
                                    @else <span class="badge bg-secondary">Belum Bayar</span>
                                    @endif
                                </td>
                                <td>{{ $billing->due_date ? $billing->due_date->format('d M Y') : '-' }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- WhatsApp Logic --}}
                                        @php
                                            $wa = $billing->user->registration->whatsapp ?? '';
                                            $waClean = preg_replace('/[^0-9]/', '', $wa);
                                            if(str_starts_with($waClean, '0')) $waClean = '62' . substr($waClean, 1);
                                            $waLink = $waClean ? "https://wa.me/{$waClean}?text=Halo%20kak!%20Tagihan%20{$billing->category}%20Semester%20{$billing->semester}%20sebesar%20Rp%20".number_format($billing->amount,0,',','.')."%20belum%20dibayar.%20Mohon%20segera%20diselesaikan." : '#';
                                        @endphp
                                        
                                        @if($waClean)
                                        <a href="{{ $waLink }}" target="_blank" class="btn btn-sm btn-outline-success" title="Chat WA (Manual)">
                                            <i class="bi bi-whatsapp"></i> Chat
                                        </a>
                                        @endif

                                        <form action="{{ route('billing.send-wa', $billing->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Kirim tagihan via WhatsApp?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Kirim Tagihan & PDF via WA">
                                                <i class="bi bi-whatsapp"></i> PDF
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.billings.print', $billing->id) }}" target="_blank" class="btn btn-sm {{ $billing->status == 'paid' ? 'btn-success' : 'btn-danger' }}" title="{{ $billing->status == 'paid' ? 'Cetak Kuitansi' : 'Cetak Tagihan' }}">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-receipt fs-1 d-block mb-3"></i>
                                    Belum ada data tagihan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($billings->hasPages())
                <div class="p-3">
                    {{ $billings->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
