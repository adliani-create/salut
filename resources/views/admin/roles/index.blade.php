@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Role Management</h2>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Add New Role</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Label</th>
                        <th>Name (Slug)</th>
                        <th>Redirect To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $role->label }}</td>
                        <td><code>{{ $role->name }}</code></td>
                        <td><code>{{ $role->redirect_to }}</code></td>
                        <td>
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this role?');">
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
