@extends('layouts.admin')

@section('title', 'Edit Program')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Program</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.career-programs.update', $careerProgram->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Program</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $careerProgram->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $careerProgram->description) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.career-programs.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Program</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
