@extends('layouts.admin')

@section('title', 'Manage Fakultas')

@section('content')
<div class="container-fluid">
    <h2>Edit Fakultas</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.fakultas.update', $fakultas->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="kode" class="form-label">Kode Fakultas</label>
                    <input type="text" class="form-control" name="kode" value="{{ $fakultas->kode }}" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Fakultas</label>
                    <input type="text" class="form-control" name="nama" value="{{ $fakultas->nama }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description">{{ $fakultas->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.fakultas.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
