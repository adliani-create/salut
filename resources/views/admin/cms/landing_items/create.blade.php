@extends('layouts.admin')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Tambah Item Baru ({{ ucfirst($section) }})</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.landing-items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="{{ $section }}">
            
            <div class="row">
                <div class="col-md-7">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Item</label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Layanan Konseling" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Penjelasan singkat..."></textarea>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar / Ikon</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Format: JPG, PNG.</div>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex mt-4">
                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                <a href="{{ route('admin.landing-items.index', ['section' => $section]) }}" class="btn btn-light px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
