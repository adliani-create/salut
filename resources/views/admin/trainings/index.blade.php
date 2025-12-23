@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Jadwal Pelatihan</h2>
        <a href="{{ route('admin.trainings.create') }}" class="btn btn-primary">Schedule New Training</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Title</th>
                        <th>Instructor</th>
                        <th>Date & Time</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trainings as $training)
                    <tr>
                        <td><span class="badge bg-primary">{{ $training->program }}</span></td>
                        <td>{{ $training->title }}</td>
                        <td>{{ $training->instructor ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($training->date)->format('d M Y') }} - {{ $training->time }}</td>
                        <td>{{ $training->location }}</td>
                        <td>
                            <a href="{{ route('admin.trainings.edit', $training->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.trainings.destroy', $training->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
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
