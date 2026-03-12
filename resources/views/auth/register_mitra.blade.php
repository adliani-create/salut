@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark">Pendaftaran Mitra SALUT</h2>
                    <p class="text-muted">Lengkapi formulir di bawah ini untuk mengajukan diri sebagai Mitra Resmi.</p>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <form action="{{ route('register.mitra.store') }}" method="POST">
                            @csrf

                            <h5 class="fw-bold text-primary border-bottom pb-2 mb-4">Informasi Akun (Login)</h5>
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-muted">Nama Lengkap PIC</label>
                                    <input id="name" type="text"
                                        class="form-control form-control-lg @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name') <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-muted">Nomor WhatsApp Aktif</label>
                                    <input id="whatsapp" type="text"
                                        class="form-control form-control-lg @error('whatsapp') is-invalid @enderror"
                                        name="whatsapp" value="{{ old('whatsapp') }}" required>
                                    @error('whatsapp') <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold small text-muted">Alamat Email</label>
                                    <input id="email" type="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email') <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-muted">Kata Sandi Baru</label>
                                    <input id="password" type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">
                                    @error('password') <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold small text-muted">Konfirmasi Kata Sandi</label>
                                    <input id="password-confirm" type="password" class="form-control form-control-lg"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <h5 class="fw-bold text-primary border-bottom pb-2 mb-4 mt-2">Informasi Institusi/Pribadi</h5>
                            <div class="row g-3">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold small text-muted">Nama Instansi / Perusahaan <span
                                            class="bg-light px-2 rounded small text-secondary">Opsional</span></label>
                                    <input id="company_name" type="text"
                                        class="form-control form-control-lg @error('company_name') is-invalid @enderror"
                                        name="company_name" value="{{ old('company_name') }}">
                                    <div class="form-text">Kosongi jika mendaftar sebagai individu.</div>
                                    @error('company_name') <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold small text-muted">Alamat Lengkap</label>
                                    <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                        name="address" rows="3">{{ old('address') }}</textarea>
                                    @error('address') <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>

                            <h5 class="fw-bold text-primary border-bottom pb-2 mb-4 mt-2">Rekening Penerimaan Pencairan</h5>
                            <div class="row g-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small text-muted">Nama Bank</label>
                                    <input id="bank_name" type="text"
                                        class="form-control @error('bank_name') is-invalid @enderror" name="bank_name"
                                        value="{{ old('bank_name') }}">
                                    @error('bank_name') <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small text-muted">Nomor Rekening</label>
                                    <input id="bank_account_number" type="text"
                                        class="form-control @error('bank_account_number') is-invalid @enderror"
                                        name="bank_account_number" value="{{ old('bank_account_number') }}">
                                    @error('bank_account_number') <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label fw-bold small text-muted">Atas Nama</label>
                                    <input id="bank_account_name" type="text"
                                        class="form-control @error('bank_account_name') is-invalid @enderror"
                                        name="bank_account_name" value="{{ old('bank_account_name') }}">
                                    @error('bank_account_name') <span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill">
                                    Kirim Pengajuan Mitra <i class="bi bi-send ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection