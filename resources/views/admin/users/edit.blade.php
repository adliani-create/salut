@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User Role</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }} ({{ $user->email }})</h5>
            <hr>
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" name="role" required>
                        <option value="mahasiswa" {{ $user->role === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="yayasan" {{ $user->role === 'yayasan' ? 'selected' : '' }}>Yayasan</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin (Super User)</option>
                    </select>
                    <div class="form-text text-danger">Warning: Changing to Admin grants full access.</div>
                </div>

                <button type="submit" class="btn btn-primary">Update Role</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
