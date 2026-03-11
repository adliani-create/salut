@extends('layouts.affiliator')

@section('title', 'Tengaturan Profil')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i>Pengaturan Profil</h5>
            </div>
            <div class="card-body p-4">
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> Profil Anda telah diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form method="post" action="{{ route('affiliator.profile.update') }}">
                    @csrf
                    @method('patch')

                    <h6 class="text-uppercase text-muted fw-bold small mb-3">Informasi Pribadi</h6>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="whatsapp" class="form-label fw-bold">No WhatsApp</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', Auth::user()->whatsapp) }}" required>
                        <div class="form-text">Contoh: 08123456789</div>
                    </div>

                    <hr class="my-4">

                    <h6 class="text-uppercase text-muted fw-bold small mb-3">Informasi Rekening Pencairan</h6>
                    <div class="mb-3">
                        <label for="bank_name" class="form-label fw-bold">Nama Bank / E-Wallet</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name', Auth::user()->bank_name) }}" placeholder="Contoh: BCA, BSI, DANA, OVO">
                    </div>

                    <div class="mb-3">
                        <label for="bank_account" class="form-label fw-bold">Nomor Rekening / No. HP E-Wallet</label>
                        <input type="text" class="form-control" id="bank_account" name="bank_account" value="{{ old('bank_account', Auth::user()->bank_account) }}">
                    </div>

                    <div class="mb-4">
                        <label for="bank_account_owner" class="form-label fw-bold">Atas Nama Rekening</label>
                        <input type="text" class="form-control" id="bank_account_owner" name="bank_account_owner" value="{{ old('bank_account_owner', Auth::user()->bank_account_owner) }}">
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">Simpan Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
