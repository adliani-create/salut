@extends('layouts.staff')

@section('title', 'Review Berkas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header fw-bold">Registration Details: {{ $registration->user->name }}</div>
                <div class="card-body">
                    <!-- Admission Receipt Feature -->
                    @if($registration->user->admission_receipt)
                        <div class="mb-4">
                            <h6 class="fw-bold text-success"><i class="bi bi-wallet2 me-2"></i>Bukti Transfer Tagihan Admisi (Rp 100.000)</h6>
                            <a href="{{ asset('storage/' . $registration->user->admission_receipt) }}" target="_blank">
                                <img src="{{ asset('storage/' . $registration->user->admission_receipt) }}" class="img-thumbnail rounded mt-2 shadow-sm" style="max-height: 200px; object-fit: cover;" alt="Bukti Transfer Admisi">
                            </a>
                            <p class="small text-muted mt-2">Status Mahasiswa: <strong class="text-uppercase">{{ $registration->user->status }}</strong></p>
                        </div>
                        <hr>
                    @endif

                    <!-- Additional Files (if any) -->
                    <h5>Berkas Pendukung Lainnya</h5>
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
