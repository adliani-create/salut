@extends('layouts.admin')

@section('title', 'Manage Semester')

@section('content')
<div class="container-fluid">
    <h2>Create Semester</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.semester.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Semester</label>
                    <input type="text" class="form-control" name="nama" placeholder="e.g. Ganjil 2024/2025" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1">
                    <label class="form-check-label" for="is_active">Set as Active Semester</label>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.semester.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
