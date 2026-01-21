@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-success text-white text-center py-4">
                    <h3 class="font-weight-light my-2">Verifikasi Mahasiswa Aktif</h3>
                    <p class="mb-0 text-white-50">Langkah 1/2: Validasi Identitas</p>
                </div>
                <div class="card-body p-5">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.existing.check') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="nim" class="form-label fw-bold">Nomor Induk Mahasiswa (NIM)</label>
                            <input id="nim" type="text" class="form-control form-control-lg @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim') }}" required autofocus placeholder="Contoh: 041xxxxxx">
                            @error('nim')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="birth_date" class="form-label fw-bold">Tanggal Lahir</label>
                            <input id="birth_date" type="date" class="form-control form-control-lg @error('birth_date') is-invalid @enderror" name="birth_date" required>
                            <div class="form-text">Sebagai verifikasi keamanan pengganti password.</div>
                            @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                Verifikasi Data <i class="bi bi-search ms-2"></i>
                            </button>
                            <a href="{{ route('register.landing') }}" class="btn btn-link text-muted">Kembali ke Pilihan</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
