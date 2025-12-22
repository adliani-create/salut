@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-info text-white shadow">
                <div class="card-body p-5">
                    <h1 class="display-4 fw-bold">Yayasan Dashboard 🏛️</h1>
                    <p class="lead">Welcome, {{ Auth::user()->name }}. Executive Overview Mode.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                 <div class="card-header">Financial Reports</div>
                 <div class="card-body">
                    <h3 class="fw-bold text-success">$1,200,000</h3>
                    <p class="text-muted">Annual Revenue</p>
                    <button class="btn btn-sm btn-outline-primary">View Report</button>
                 </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                 <div class="card-header">Total Students</div>
                 <div class="card-body">
                    <h3 class="fw-bold text-primary">3,450</h3>
                    <p class="text-muted">Registered Active Students</p>
                 </div>
            </div>
        </div>
         <div class="col-md-4">
            <div class="card">
                 <div class="card-header">Employee Stats</div>
                 <div class="card-body">
                    <h3 class="fw-bold text-dark">120</h3>
                    <p class="text-muted">Lecturers & Staff</p>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
