@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">LMS Materials</h1>
        <a href="{{ route('admin.lms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Upload Material
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Track</th>
                            <th>Type</th>
                            <th>Uploaded At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materials as $material)
                        <tr>
                            <td>{{ $material->title }}</td>
                            <td><span class="badge bg-secondary">{{ $material->track }}</span></td>
                            <td>
                                @if($material->type == 'video')
                                    <span class="badge bg-primary"><i class="bi bi-camera-video margin-icon"></i> Video</span>
                                @else
                                    <span class="badge bg-success"><i class="bi bi-file-earmark-pdf margin-icon"></i> E-Book</span>
                                @endif
                            </td>
                            <td>{{ $material->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('admin.lms.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No materials found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
