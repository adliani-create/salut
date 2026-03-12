@extends('layouts.admin')

@section('title', 'Tinjau Persetujuan Admisi')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-search me-2"></i>Review Pembayaran Admisi</h1>
        <a href="{{ route('admin.admissions.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left fa-sm text-secondary me-1"></i> Kembali ke Antrean
        </a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Receipt Image Preview -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4 border-0 h-100">
                <div class="card-header py-3 bg-white border-0">
                    <h6 class="m-0 font-weight-bold text-primary">Pratinjau Bukti Transfer (Rp 100.000)</h6>
                </div>
                <div class="card-body text-center bg-light d-flex align-items-center justify-content-center" style="min-height: 400px;">
                    @if($user->admission_receipt)
                        <img src="{{ asset('storage/' . $user->admission_receipt) }}" class="img-fluid rounded shadow" style="max-height: 600px; object-fit: contain;" alt="Struk Admisi">
                    @else
                        <div class="text-muted">
                            <i class="bi bi-image-alt display-1 mb-3 d-block"></i>
                            <p>Tidak ada gambar yang diunggah.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Panel -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4 border-0">
                <div class="card-header py-3 bg-white border-0">
                    <h6 class="m-0 font-weight-bold text-dark">Data Pendaftar & Eksekusi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="small text-muted fw-bold text-uppercase">Nama Mahasiswa</label>
                        <div class="fs-5 fw-bold text-dark">{{ $user->name }}</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="small text-muted fw-bold text-uppercase">Email</label>
                        <div>{{ $user->email }}</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="small text-muted fw-bold text-uppercase">Waktu Upload</label>
                        <div>{{ $user->updated_at->format('d M Y, H:i:s') }}</div>
                        <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                    </div>

                    <hr>
                    
                    <div class="p-3 bg-light rounded-3 mb-4 border">
                        <label class="small text-muted fw-bold text-uppercase mb-2"><i class="bi bi-diagram-3-fill me-1"></i> Referal Pengajak</label>
                        @if($user->referred_by)
                            @php $referrer = \App\Models\User::find($user->referred_by); @endphp
                            @if($referrer)
                                <div class="fw-bold text-primary mb-1">{{ $referrer->name }}</div>
                                <span class="badge bg-info text-dark mb-2">Ref: {{ $referrer->referral_code }}</span>
                                <div class="alert alert-warning py-2 mb-0 border-warning small">
                                    <i class="bi bi-gift-fill me-1"></i> Jika <strong>Disahkan</strong>, Affiliator ini otomatis menerima komisi +50 Poin (Rp 50.000).
                                </div>
                            @else
                                <div class="text-muted fst-italic">Organik (Tanpa Referal)</div>
                            @endif
                        @else
                            <div class="text-muted fst-italic">Organik (Tanpa Referal)</div>
                        @endif
                    </div>

                    <!-- Approval Buttons -->
                    <form action="{{ route('admin.admissions.approve', $user->id) }}" method="POST" class="mb-3" onsubmit="return confirm('Sahkan pembayaran ini? Mahasiswa akan menjadi aktif dan komisi akan dibagikan.');">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow-sm rounded-pill">
                            <i class="bi bi-check-circle-fill me-2"></i> Sahkan Pembayaran (Approve)
                        </button>
                    </form>

                    <!-- Rejection Button -->
                    <form action="{{ route('admin.admissions.reject', $user->id) }}" method="POST" onsubmit="return confirm('Tolak pembayaran ini? Mahasiswa akan diminta mengunggah ulang bukti transfer.');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill fw-bold">
                            <i class="bi bi-x-circle me-1"></i> Bukti Tidak Valid (Tolak)
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
