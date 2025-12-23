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
                        <th>File</th>
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
                            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Download/View</a>
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
