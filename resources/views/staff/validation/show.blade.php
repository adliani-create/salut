@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header fw-bold">Registration Details: {{ $registration->user->name }}</div>
                <div class="card-body">
                    <h5>Uploaded Files</h5>
                    {{-- Assuming files is an array of paths or similar, ad-hoc implementation --}}
                    <ul>
                        @foreach($registration->files ?? [] as $file)
                            <li><a href="{{ asset('storage/' . $file) }}" target="_blank">View File</a></li>
                        @endforeach
                    </ul>
                    <hr>
                    <h5>Current Status: 
                        <span class="badge bg-{{ $registration->status == 'valid' ? 'success' : ($registration->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </h5>
                    <p class="text-muted">Registered on: {{ $registration->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Validation Action</div>
                <div class="card-body">
                    <form action="{{ route('staff.validation.update', $registration->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Set Status</label>
                            <select name="status" class="form-select">
                                <option value="valid" {{ $registration->status == 'valid' ? 'selected' : '' }}>Valid (Approve)</option>
                                <option value="invalid" {{ $registration->status == 'invalid' ? 'selected' : '' }}>Invalid (Reject)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes (Optional)</label>
                            <textarea name="admin_notes" class="form-control" rows="3">{{ $registration->admin_notes }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
