@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <h2>Edit Role</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Role Name (Internal)</label>
                    <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Label (Display Name)</label>
                    <input type="text" name="label" class="form-control" value="{{ $role->label }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Redirect Route (After Login)</label>
                    <input type="text" name="redirect_to" class="form-control" value="{{ $role->redirect_to }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Role</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
