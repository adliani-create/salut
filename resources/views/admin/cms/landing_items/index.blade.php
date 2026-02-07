@extends('layouts.admin')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Kelola Konten: {{ $sectionLabels[$section] ?? ucfirst($section) }}</h5>
            <small class="text-muted">Manajemen item daftar untuk bagian ini.</small>
        </div>
        <a href="{{ route('admin.landing-items.create', ['section' => $section]) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Baru
        </a>
    </div>
    
    <!-- Filter Tabs -->
    <div class="card-body pb-0">
        <ul class="nav nav-tabs">
            @foreach($sectionLabels as $key => $label)
            <li class="nav-item">
                <a class="nav-link {{ $section == $key ? 'active fw-bold' : 'text-muted' }}" href="{{ route('admin.landing-items.index', ['section' => $key]) }}">
                    {{ $label }}
                </a>
            </li>
            @endforeach
        </ul>
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
                        <th width="10%">Gambar</th>
                        <th>Judul Item</th>
                        <th>Deskripsi Singkat</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $loop->iteration + $items->firstItem() - 1 }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" class="rounded bg-light" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="badge bg-light text-dark">No Img</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $item->title }}</td>
                            <td>{{ Str::limit($item->description, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.landing-items.edit', $item->id) }}" class="btn btn-sm btn-info text-white me-1"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.landing-items.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada item untuk bagian ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection
