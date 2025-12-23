@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    {{-- Stats Cards --}}
    <div class="row g-3 my-2">
        <div class="col-md-3">
            <div class="card p-3 bg-white d-flex justify-content-between align-items-center h-100">
                <div>
                    <h3 class="fs-2 fw-bold text-warning">{{ $stats['total_roles'] ?? 0 }}</h3>
                    <p class="fs-5 text-muted mb-0">Roles</p>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-shield-lock fs-1 text-warning"></i>
                </div>
            </div>
        </div>
        
         <div class="col-md-3">
            <div class="card p-3 bg-white d-flex justify-content-between align-items-center h-100">
                <div>
                    <h3 class="fs-2 fw-bold text-success">{{ $stats['total_fakultas'] ?? 0 }}</h3>
                    <p class="fs-5 text-muted mb-0">Fakultas</p>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-building fs-1 text-success"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card p-3 bg-white d-flex justify-content-between align-items-center h-100">
                <div>
                    <h3 class="fs-2 fw-bold text-info">{{ $stats['total_prodi'] ?? 0 }}</h3>
                    <p class="fs-5 text-muted mb-0">Prodi</p>
                </div>
                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                    <i class="bi bi-book fs-1 text-info"></i>
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card p-4">
                <h4 class="mb-3">System Overview</h4>
                <p>Welcome to the new Admin Dashboard layout. Use the sidebar to navigate between modules.</p>
                
                <div class="alert alert-info border-0 shadow-sm">
                    <i class="bi bi-info-circle-fill me-2"></i> Use the hamburger menu in the top left to toggle the sidebar on mobile devices.
                </div>
            </div>
        </div>
    </div>
@endsection
