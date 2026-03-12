@extends('layouts.staff')

@section('title', 'Upload Bahan Ajar')

@section('content')
<div class="container-fluid">
    <h2>Distribute Teaching Material</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('staff.materials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Program (Target)</label>
                        <select name="program" class="form-select">
                            <option value="">All Programs</option>
                            <option value="Kuliah plus Magang Kerja">Kuliah plus Magang Kerja</option>
                            <option value="Kuliah Plus Skill Academy">Kuliah Plus Skill Academy</option>
                            <option value="Kuliah plus Affiliator & Creator">Kuliah plus Affiliator & Creator</option>
                            <option value="Kuliah Plus Wirausaha">Kuliah Plus Wirausaha</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Semester</label>
                         <select name="semester" class="form-select">
                            <option value="">All Semesters</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">File</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Distribute</button>
            </form>
        </div>
    </div>
</div>
@endsection
