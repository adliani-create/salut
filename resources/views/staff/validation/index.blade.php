@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Validasi Berkas Mahasiswa Baru</h2>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                    <tr>
                        <td>{{ $reg->created_at->format('d M Y') }}</td>
                        <td>{{ $reg->user->name }}</td>
                        <td>{{ $reg->user->email }}</td>
                        <td>
                            @if($reg->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($reg->status == 'valid')
                                <span class="badge bg-success">Valid</span>
                            @else
                                <span class="badge bg-danger">Invalid</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('staff.validation.show', $reg->id) }}" class="btn btn-sm btn-primary">Review</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No registrations found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
