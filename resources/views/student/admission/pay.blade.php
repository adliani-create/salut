@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Alert Berhasil Upload -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header -->
                <div class="card-header @if($user->status == 'pending_verification') bg-warning @else bg-primary @endif text-white text-center py-4 border-0">
                    <div class="mb-3">
                        @if($user->status == 'pending_verification')
                            <i class="bi bi-hourglass-split display-4"></i>
                        @else
                            <i class="bi bi-wallet2 display-4"></i>
                        @endif
                    </div>
                    <h3 class="fw-bold mb-1">
                        @if($user->status == 'pending_verification')
                            Menunggu Verifikasi Admin
                        @else
                            Pembayaran Admisi Pendaftaran
                        @endif
                    </h3>
                    <p class="mb-0 opacity-75">
                        @if($user->status == 'pending_verification')
                            Bukti pembayaran Anda sedang kami tinjau.
                        @else
                            Selesaikan pembayaran untuk mengaktifkan akun.
                        @endif
                    </p>
                </div>

                <div class="card-body p-4 p-md-5 bg-light">
                    @if($user->status == 'pending_verification')
                        <!-- State: Menunggu Verifikasi -->
                        <div class="text-center py-4">
                            <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border d-inline-block">
                                <img src="{{ asset('storage/' . $user->admission_receipt) }}" alt="Bukti Transfer" class="img-fluid rounded" style="max-height: 250px; object-fit: contain;">
                            </div>
                            <h4 class="fw-bold text-dark">Terima Kasih, {{ $user->name }}!</h4>
                            <p class="text-muted mb-4">Bukti transfer Anda telah berhasil dikirim. Admin kami sedang memverifikasi pembayaran Anda. Akses <strong>Dashboard Utama</strong> akan terbuka otomatis setelah pembayaran disetujui (biasanya dalam 1x24 jam kerja).</p>
                            
                            <a href="{{ route('student.admission.pay') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="bi bi-arrow-clockwise me-1"></i> Cek Status Terbaru
                            </a>
                        </div>
                    @else
                        <!-- State: Belum Bayar -->
                        <div class="row gx-lg-5">
                            <!-- Instruksi Transfer -->
                            <div class="col-lg-6 mb-4 mb-lg-0 border-end-lg">
                                <h5 class="fw-bold text-dark mb-4"><i class="bi bi-info-circle text-primary me-2"></i>Instruksi Pembayaran</h5>
                                
                                <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                                    <p class="small text-muted mb-1 text-uppercase fw-bold">Total Tagihan Admisi</p>
                                    <h2 class="fw-bold text-primary mb-0">Rp 100.000</h2>
                                </div>

                                <div class="bg-white p-4 rounded-4 shadow-sm border border-start border-4 border-warning">
                                    <p class="small text-muted mb-1 text-uppercase fw-bold">Transfer Ke Rekening Berikut:</p>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-light p-2 rounded me-3">
                                            <i class="bi bi-bank fs-3 text-secondary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark">Bank BRI</h6>
                                            <p class="mb-0 font-monospace fs-5">0123-4567-8910</p>
                                        </div>
                                    </div>
                                    <p class="small text-muted mb-0">A.n. <strong>PT Indoglobal Salut</strong></p>
                                </div>
                            </div>

                            <!-- Form Upload -->
                            <div class="col-lg-6">
                                <h5 class="fw-bold text-dark mb-4"><i class="bi bi-cloud-arrow-up text-primary me-2"></i>Konfirmasi Pembayaran</h5>
                                
                                <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                                    <form action="{{ route('student.admission.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="payment_receipt" class="form-label fw-bold text-dark small">Upload Bukti Transfer</label>
                                            <div class="custom-file-upload border rounded-3 p-3 text-center bg-light position-relative" style="border-style: dashed !important; border-width: 2px !important; border-color: #dee2e6 !important;">
                                                <i class="bi bi-image fs-1 text-muted mb-2"></i>
                                                <p class="small text-muted mb-2" id="file-name-display">Pilih file struk/screenshot transfer Anda. (Maks 2MB, format JPG/PNG)</p>
                                                <input class="form-control" type="file" id="payment_receipt" name="payment_receipt" accept=".jpg,.jpeg,.png" required style="cursor: pointer;" onchange="updateFileName(this)">
                                            </div>
                                            @error('payment_receipt')
                                                <div class="text-danger small mt-2 fw-bold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-grid mt-auto">
                                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                                Kirim Bukti Pembayaran <i class="bi bi-send ms-1"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="text-center mt-4">
                 <a class="text-decoration-none text-muted small" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     <i class="bi bi-box-arrow-right me-1"></i> Keluar (Logout)
                 </a>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Tambahan khusus halaman ini */
@media (min-width: 992px) {
    .border-end-lg {
        border-right: 1px solid #dee2e6;
    }
}
.custom-file-upload input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}
.custom-file-upload:hover {
    border-color: #0d6efd !important;
    background-color: #e9ecef !important;
    transition: all 0.2s ease;
}
</style>

<script>
function updateFileName(input) {
    const display = document.getElementById('file-name-display');
    if (input.files && input.files.length > 0) {
        display.innerHTML = '<strong class="text-primary">' + input.files[0].name + '</strong> siap diunggah';
        display.classList.remove('text-muted');
        display.classList.add('text-dark');
    } else {
        display.innerHTML = 'Pilih file struk/screenshot transfer Anda. (Maks 2MB, format JPG/PNG)';
        display.classList.remove('text-dark');
        display.classList.add('text-muted');
    }
}
</script>
@endsection
