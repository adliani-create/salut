@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tiket Support</h2>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Student</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ $ticket->subject }}</td>
                        <td>{{ $ticket->user->name }}</td>
                        <td>
                            @if($ticket->status == 'open')
                                <span class="badge bg-danger">Open</span>
                            @elseif($ticket->status == 'answered')
                                <span class="badge bg-success">Answered</span>
                            @else
                                <span class="badge bg-secondary">Closed</span>
                            @endif
                        </td>
                        <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('staff.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">Open</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No tickets found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
