@extends('layouts.admin')

@section('title', 'Generate Tagihan Massal')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-collection me-2"></i>Generate Tagihan Massal</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.billings.store-bulk') }}" method="POST">
                    @csrf
                    
                    <h6 class="text-secondary border-bottom pb-2 mb-3">1. Target Mahasiswa</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Angkatan (Tahun Masuk)</label>
                            <select name="year" class="form-select @error('year') is-invalid @enderror" required>
                                @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fakultas (Opsional)</label>
                            <select name="faculty" class="form-select">
                                <option value="">Semua Fakultas</option>
                                @foreach($fakultas as $f)
                                    <option value="{{ $f }}">{{ $f }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Kosongkan untuk mengirim ke semua jurusan di angkatan tersebut.</div>
                        </div>
                    </div>

                    <h6 class="text-secondary border-bottom pb-2 mb-3">2. Detail Tagihan</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label">Kategori Tagihan</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat1" value="Layanan SALUT" checked>
                                    <label class="form-check-label" for="cat1">Layanan SALUT</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat2" value="UKT">
                                    <label class="form-check-label" for="cat2">UKT</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat3" value="SPI">
                                    <label class="form-check-label" for="cat3">SPI / Pangkal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat4" value="Lainnya">
                                    <label class="form-check-label" for="cat4">Lainnya</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Semester</label>
                            <select name="semester" class="form-select" required>
                                @for($i=1; $i<=8; $i++) <option value="{{ $i }}">Semester {{ $i }}</option> @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tenggat Waktu (Due Date)</label>
                            <input type="date" name="due_date" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nominal (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="amount" class="form-control" placeholder="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                        <div>
                            Pastikan data sudah benar. Tagihan akan dibuat untuk seluruh mahasiswa aktif sesuai kriteria di atas.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.billings.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Generate Tagihan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
