@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Distribusi Bahan Ajar</h2>
        <a href="{{ route('staff.materials.create') }}" class="btn btn-primary">Upload Material</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Program</th>
                        <th>Semester</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $mat)
                    <tr>
                        <td>{{ $mat->title }}</td>
                        <td>{{ $mat->program ?? '-' }}</td>
                        <td>{{ $mat->semester ?? '-' }}</td>
                        <td><a href="{{ asset('storage/' . $mat->file_path) }}" target="_blank">Download</a></td>
                        <td>
                            <form action="{{ route('staff.materials.destroy', $mat->id) }}" method="POST" onsubmit="return confirm('Delete?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No materials distributed yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
