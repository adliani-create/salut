@extends('layouts.admin')

@section('title', 'Edit Training')

@section('content')
<div class="container-fluid">
    <h2>Edit Training</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.trainings.update', $training->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Program Salut (Target Audience)</label>
                    <div class="card p-3 bg-light">
                        <div class="row">
                            @foreach($programs as $program)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="career_program_ids[]" value="{{ $program->id }}" id="program_{{ $program->id }}"
                                            {{ in_array($program->id, $training->careerPrograms->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="program_{{ $program->id }}">
                                            {{ $program->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
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
