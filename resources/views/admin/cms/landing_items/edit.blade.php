@extends('layouts.admin')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Edit Item</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.landing-items.update', $landingItem->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-7">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Item</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $landingItem->title) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="5">{{ old('description', $landingItem->description) }}</textarea>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar / Ikon</label>
                        @if($landingItem->image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($landingItem->image) }}" class="img-fluid rounded border" style="max-height: 100px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex mt-4">
                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                <a href="{{ route('admin.landing-items.index', ['section' => $landingItem->section]) }}" class="btn btn-light px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
