@extends('layouts.admin')

@section('title', 'Master Program')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Master Program Unggulan</h1>
        <a href="{{ route('admin.career-programs.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Tambah Program
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light text-primary">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Program</th>
                            <th>Deskripsi</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $index => $program)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $program->name }}</td>
                            <td>{{ $program->description ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.career-programs.edit', $program->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.career-programs.destroy', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus program ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data program.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
