@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h4 class="text-primary fw-bold mb-4">Verifikasi Pembayaran (Menunggu Konfirmasi)</h4>
        
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Tagihan</th>
                                <th>Bukti Bayar</th>
                                <th>Waktu Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($billings as $billing)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $billing->user->name }}</div>
                                    <div class="small text-muted">{{ $billing->user->nim ?? '-' }}</div>
                                    <div class="small text-muted">{{ $billing->user->major }} - Sem {{ $billing->semester }}</div>
                                </td>
                                <td>
                                    <div>{{ $billing->category }}</div>
                                    <div class="fw-bold text-primary">Rp {{ number_format($billing->amount, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    @if($billing->payment_proof)
                                        <a href="{{ asset('storage/' . $billing->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-image me-1"></i> Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-danger small">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>{{ $billing->payment_date ? $billing->payment_date->diffForHumans() : '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.billings.approve', $billing->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah bukti pembayaran sudah valid?')">
                                                <i class="bi bi-check-lg me-1"></i> Terima
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $billing->id }}">
                                            <i class="bi bi-x-lg me-1"></i> Tolak
                                        </button>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $billing->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="{{ route('admin.billings.reject', $billing->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Tolak Pembayaran</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="form-label">Alasan Penolakan</label>
                                                        <textarea name="reason" class="form-control" rows="3" required placeholder="Contoh: Bukti buram, nominal tidak sesuai..."></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-check-circle fs-1 d-block mb-3"></i>
                                    Tidak ada pembayaran yang menunggu verifikasi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
