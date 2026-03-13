@extends('layouts.admin')

@section('title', 'Persetujuan Admisi Pendaftaran Baru')

@section('content')
<div class="container-fluid p-4">
    <div class="row mb-4 align-items-center">
        <div class="col-8">
            <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-wallet2 me-2"></i>Persetujuan Pembayaran Admisi</h1>
            <p class="text-muted mt-2">Daftar Mahasiswa Baru yang telah mengunggah bukti transfer Admisi Rp 100.000 dan menunggu sah dari Admin.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0 overflow-hidden">
        <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Antrean Menunggu Verifikasi ({{ $pendingAdmissions->count() }})</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Nama Mahasiswa</th>
                            <th scope="col">Email & WhatsApp</th>
                            <th scope="col">Afiliasi Pengajak</th>
                            <th scope="col">Waktu Upload</th>
                            <th scope="col" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingAdmissions as $student)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $student->name }}</div>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                </td>
                                <td>
                                    <div>{{ $student->email }}</div>
                                    <small class="text-muted">{{ $student->whatsapp ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($student->referred_by)
                                        @php $referrer = \App\Models\User::find($student->referred_by); @endphp
                                        @if($referrer)
                                            <div class="fw-bold">{{ $referrer->name }}</div>
                                            <span class="badge bg-info text-dark">Referral ID: {{ $referrer->referral_code }}</span>
                                        @else
                                            <span class="text-muted fst-italic">Organik (Tanpa Referal)</span>
                                        @endif
                                    @else
                                        <span class="text-muted fst-italic">Organik (Tanpa Referal)</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $student->updated_at->diffForHumans() }}
                                    <div class="small text-muted">{{ $student->updated_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('admin.admissions.show', $student->id) }}" class="btn btn-primary btn-sm rounded-pill fw-bold">
                                        <i class="bi bi-search me-1"></i> Tinjau Struk
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="bg-light rounded-circle p-4 mb-3">
                                            <i class="bi bi-check2-all text-success fs-1"></i>
                                        </div>
                                        <h5 class="text-muted fw-bold">Tidak ada antrean Admisi</h5>
                                        <p class="text-muted small">Semua pendaftar baru yang masuk sudah ditangani atau belum ada yang mengunggah bukti pembayaran.</p>
                                    </div>
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
