@extends('layouts.admin')

@section('title', 'Manage Semester')

@section('content')
<div class="container-fluid">
    <h2>Edit Semester</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.semester.update', $semester->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Semester</label>
                    <input type="text" class="form-control" name="nama" value="{{ $semester->nama }}" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" {{ $semester->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Set as Active Semester</label>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.semester.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
