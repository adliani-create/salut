@extends('layouts.admin')

@section('title', 'Manage Prodi')

@section('content')
<div class="container-fluid">
    <h2>Create Program Studi</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.prodi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="fakultas_id" class="form-label">Fakultas</label>
                    <select class="form-select" name="fakultas_id" required>
                        <option value="">Select Fakultas</option>
                        @foreach($fakultas as $f)
                            <option value="{{ $f->id }}">{{ $f->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kode" class="form-label">Kode Prodi</label>
                    <input type="text" class="form-control" name="kode" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Prodi</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="jenjang" class="form-label">Jenjang</label>
                    <select class="form-select" name="jenjang" required>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.prodi.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
