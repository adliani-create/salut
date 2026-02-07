@extends('layouts.admin')

@section('title', 'Create Role')

@section('content')
<div class="container-fluid">
    <h2>Create New Role</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Role Name (Internal)</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., student_admin" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Label (Display Name)</label>
                    <input type="text" name="label" class="form-control" placeholder="e.g., Student Admin" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Redirect Route (After Login)</label>
                    <input type="text" name="redirect_to" class="form-control" placeholder="e.g., admin.dashboard" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Role</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
