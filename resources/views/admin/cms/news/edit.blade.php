@extends('layouts.admin')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Edit Berita</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Berita</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konten Berita</label>
                        <textarea name="content" class="form-control" rows="10" required>{{ old('content', $news->content) }}</textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Sampul</label>
                        @if($news->thumbnail)
                            <div class="mb-2">
                                <img src="{{ Storage::url($news->thumbnail) }}" class="img-fluid rounded" alt="Current">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengganti gambar.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="published" {{ $news->status == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ $news->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-light mt-2">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
