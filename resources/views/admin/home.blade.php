@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Admin Welcome --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-dark text-white shadow">
                <div class="card-body p-5">
                    <h1 class="display-4 fw-bold">Admin Dashboard 🛡️</h1>
                    <p class="lead">Welcome, {{ Auth::user()->name }}. You have full control over the system.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Admin Stats --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users 👥</h5>
                    <h2 class="fw-bold">{{ $stats['total_users'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Revenue 💰</h5>
                    <h2 class="fw-bold">$45,000</h2>
                </div>
            </div>
        </div>
         <div class="col-md-3">
            <div class="card bg-warning text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Issues ⚠️</h5>
                    <h2 class="fw-bold">5</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Server Load 🖥️</h5>
                    <h2 class="fw-bold">12%</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Admin Actions --}}
    <div class="row">
        <div class="col-md-12">
             <div class="card">
                <div class="card-header fw-bold">Master Data & Actions</div>
                <div class="card-body">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark me-2"><i class="bi bi-people"></i> Users</a>
                    <hr>
                    <a href="{{ route('admin.fakultas.index') }}" class="btn btn-outline-primary me-2"><i class="bi bi-building"></i> Fakultas</a>
                    <a href="{{ route('admin.prodi.index') }}" class="btn btn-outline-info me-2"><i class="bi bi-book"></i> Prodi</a>
                    <a href="{{ route('admin.semester.index') }}" class="btn btn-outline-success me-2"><i class="bi bi-calendar-event"></i> Semester</a>
                    <hr>
                    <button class="btn btn-outline-secondary me-2"><i class="bi bi-gear"></i> Settings</button>
                    <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Clear Cache</button>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Non-Academic Modules --}}
    <div class="row mt-4">
        <div class="col-md-12">
             <div class="card">
                <div class="card-header fw-bold">Non-Academic Modules</div>
                <div class="card-body">
                    <a href="{{ route('admin.lms-materials.index') }}" class="btn btn-outline-success me-2"><i class="bi bi-journal-album"></i> LMS Lokal (Materi)</a>
                    <a href="{{ route('admin.trainings.index') }}" class="btn btn-outline-info me-2"><i class="bi bi-calendar-check"></i> Jadwal Pelatihan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
