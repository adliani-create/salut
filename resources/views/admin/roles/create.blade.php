@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Role</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Role Label</label>
                    <input type="text" name="label" class="form-control" placeholder="e.g. Dean Of Engineering" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role Name (Slug)</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. dean" required>
                    <div class="form-text">Unique identifier, no spaces.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Redirect To (Route Name)</label>
                    <input type="text" name="redirect_to" class="form-control" value="home" required>
                    <div class="form-text">The named route to redirect to after login (e.g. 'home', 'admin.dashboard').</div>
                </div>
                <button type="submit" class="btn btn-primary">Save Role</button>
            </form>
        </div>
    </div>
</div>
@endsection
