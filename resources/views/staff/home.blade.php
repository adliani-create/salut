@extends('layouts.staff')

@section('title', 'Staff Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-5 fw-bold">Staff Dashboard 👨‍💼</h1>
            <p class="lead">Welcome back, {{ $user->name }}.</p>
        </div>
    </div>

    <div class="row mb-4">
        {{-- Validation Widget --}}
        <div class="col-md-6">
            <div class="card bg-warning text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Validasi Berkas Maba 📝</h5>
                    <p class="card-text display-6">{{ $pendingValidations }} Pending</p>
                    <a href="{{ route('staff.validation.index') }}" class="btn btn-dark">Process Validations</a>
                </div>
            </div>
        </div>
        
        {{-- Ticket Widget --}}
        <div class="col-md-6">
            <div class="card bg-info text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tiket Support 🎫</h5>
                    <p class="card-text display-6">{{ $openTickets }} Open</p>
                    <a href="{{ route('staff.tickets.index') }}" class="btn btn-dark">Manage Tickets</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fw-bold">Pelayanan & Distribusi</div>
                <div class="card-body">
                    <a href="{{ route('staff.materials.index') }}" class="btn btn-outline-primary me-2"><i class="bi bi-book"></i> Distribusi Bahan Ajar</a>
                    <!-- Add more links if needed -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
