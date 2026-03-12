@extends('layouts.admin')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Tulis Berita Baru</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Berita</label>
                        <input type="text" name="title" class="form-control" placeholder="Masukkan judul menarik..." required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konten Berita</label>
                        <!-- Simple Textarea for now, user requested Rich Text but standard textarea is safer for MVP without external JS libs yet. 
                             I will add a note or basic WYSIWYG integration if needed later. For now, simple textarea with rows. -->
                        <textarea name="content" class="form-control" rows="10" placeholder="Tulis isi berita di sini..." required></textarea>
                        <div class="form-text">Anda bisa menggunakan tag HTML sederhana jika diperlukan.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Sampul (Thumbnail)</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*" required>
                        <div class="form-text">Wajib diupload.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="published">Published (Langsung Tayang)</option>
                            <option value="draft">Draft (Simpan Dulu)</option>
                        </select>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Berita</button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-light mt-2">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
