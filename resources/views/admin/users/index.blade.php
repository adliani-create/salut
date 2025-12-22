@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>User Management</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role && $user->role->name === 'admin')
                                <span class="badge bg-danger">{{ $user->role->label }}</span>
                            @elseif($user->role && $user->role->name === 'yayasan')
                                <span class="badge bg-warning text-dark">{{ $user->role->label }}</span>
                            @elseif($user->role && $user->role->name === 'staff')
                                <span class="badge bg-info text-dark">{{ $user->role->label }}</span>
                            @elseif($user->role && $user->role->name === 'mahasiswa')
                                <span class="badge bg-secondary">{{ $user->role->label }}</span>
                            @elseif($user->role)
                                <span class="badge bg-light text-dark">{{ $user->role->label }}</span> <!-- Fallback for new dynamic roles -->
                            @else
                                <span class="badge bg-dark">No Role</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit Role</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" {{ auth()->id() === $user->id ? 'disabled' : '' }}>Delete</button>
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
