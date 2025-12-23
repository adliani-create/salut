@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            {{-- Ticket Header --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between">
                    <strong>#{{ $ticket->id }}: {{ $ticket->subject }}</strong>
                    <span class="badge bg-{{ $ticket->status == 'open' ? 'danger' : 'success' }}">{{ ucfirst($ticket->status) }}</span>
                </div>
                <div class="card-body">
                    <p>{{ $ticket->message }}</p>
                    <small class="text-muted">By {{ $ticket->user->name }} on {{ $ticket->created_at->format('d M Y H:i') }}</small>
                </div>
            </div>

            {{-- Replies --}}
            @foreach($ticket->replies as $reply)
            <div class="card mb-3 {{ $reply->user_id == auth()->id() ? 'border-primary' : '' }}">
                <div class="card-body">
                    <p>{{ $reply->message }}</p>
                    <small class="text-muted">
                        {{ $reply->user->name }} ({{ $reply->user->role->label ?? 'Role' }}) - {{ $reply->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
            @endforeach

            {{-- Reply Form --}}
            <div class="card mt-4">
                <div class="card-body">
                    <h5>Post Reply</h5>
                    <form action="{{ route('staff.tickets.reply', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="message" class="form-control" rows="3" required placeholder="Type your reply..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Actions</h5>
                    <form action="{{ route('staff.tickets.status', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                             <select name="status" class="form-select form-select-sm">
                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="answered" {{ $ticket->status == 'answered' ? 'selected' : '' }}>Answered</option>
                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-secondary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
