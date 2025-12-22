@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body p-5">
                    <h1 class="display-4 fw-bold">Layanan Akademik 🛠️</h1>
                    <p class="lead">Welcome, {{ Auth::user()->name }}. Staff Operations Panel.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                 <div class="card-header">Student Services</div>
                 <div class="card-body">
                    <button class="btn btn-primary me-2"><i class="bi bi-card-checklist"></i> Verify KRS</button>
                    <button class="btn btn-outline-dark me-2"><i class="bi bi-printer"></i> Print Transcripts</button>
                 </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                 <div class="card-header">Schedule Management</div>
                 <div class="card-body">
                    <button class="btn btn-info text-white me-2"><i class="bi bi-calendar-week"></i> Manage Class Schedules</button>
                    <button class="btn btn-outline-secondary"><i class="bi bi-door-open"></i> Room Booking</button>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
