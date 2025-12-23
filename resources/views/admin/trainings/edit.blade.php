@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Training</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.trainings.update', $training->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Program Salut</label>
                    <select name="program" class="form-select" required>
                        <option value="">Select Program</option>
                        @foreach($programs as $program)
                            <option value="{{ $program }}" {{ $training->program == $program ? 'selected' : '' }}>{{ $program }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Training Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $training->title }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Instructor</label>
                    <input type="text" name="instructor" class="form-control" value="{{ $training->instructor }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $training->date }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Time</label>
                        <input type="time" name="time" class="form-control" value="{{ $training->time }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Location (Address or Link)</label>
                    <input type="text" name="location" class="form-control" value="{{ $training->location }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $training->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Schedule</button>
            </form>
        </div>
    </div>
</div>
@endsection
