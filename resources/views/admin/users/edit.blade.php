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
                    <select class="form-select" name="role_id" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->label }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text text-danger">Warning: Changing to Admin grants full access. (Admin ID: 1)</div>
                </div>

                <button type="submit" class="btn btn-primary">Update Role</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
