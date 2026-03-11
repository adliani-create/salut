@extends('layouts.admin')

@section('title', 'LMS Materials')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>LMS Lokal - Materials</h2>
        <a href="{{ route('admin.lms-materials.create') }}" class="btn btn-primary">Upload Material</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Link</th>
                        <th>Source</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $material)
                    <tr>
                        <td>{{ $material->title }}</td>
                        <td>
                            @if($material->type == 'video')
                                <span class="badge bg-danger">Video</span>
                            @else
                                <span class="badge bg-info">E-Book</span>
                            @endif
                        </td>
                        <td>
                            @if($material->url)
                                <a href="{{ $material->url }}" target="_blank" class="btn btn-sm btn-outline-primary">Visit Link</a>
                            @elseif($material->file_path)
                                <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Download (Legacy)</a>
                            @else
                                <span class="text-muted">No Link</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary text-uppercase">{{ $material->source_type ?? 'Local' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.lms-materials.edit', $material->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.lms-materials.destroy', $material->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
