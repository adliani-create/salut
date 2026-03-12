@extends('layouts.admin')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Manajemen Berita</h5>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tulis Berita
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Thumbnail</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tanggal Publish</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr>
                            <td>{{ $loop->iteration + $news->firstItem() - 1 }}</td>
                            <td>
                                @if($item->thumbnail)
                                    <img src="{{ Storage::url($item->thumbnail) }}" alt="Thumb" class="rounded" style="width: 80px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted small">No Image</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-truncate" style="max-width: 300px;">{{ $item->title }}</div>
                                <small class="text-muted">Slug: {{ $item->slug }}</small>
                            </td>
                            <td>
                                @if($item->status == 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $item->published_at ? $item->published_at->format('d M Y H:i') : '-' }}</td>
                            <td>
                                <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-info text-white me-1"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
