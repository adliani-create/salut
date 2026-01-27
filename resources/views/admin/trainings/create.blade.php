@extends('layouts.admin')

@section('title', 'Schedule Training')

@section('content')
<div class="container-fluid">
    <h2>Schedule Training</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.trainings.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Program Salut (Target Audience)</label>
                    <div class="card p-3 bg-light">
                        <div class="row">
                            @foreach($programs as $program)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="career_program_ids[]" value="{{ $program->id }}" id="program_{{ $program->id }}">
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
                    <input type="text" name="title" class="form-control" required placeholder="e.g. Digital Marketing 101">
                </div>
                <div class="mb-3">
                    <label class="form-label">Instructor</label>
                    <input type="text" name="instructor" class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Time</label>
                        <input type="time" name="time" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Location (Address or Link)</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Schedule</button>
            </form>
        </div>
    </div>
</div>
@endsection
