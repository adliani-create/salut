
@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Welcome Banner --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold text-dark">Hello, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-muted">Welcome back to your dashboard. Here's what's happening today.</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Sales</p>
                        <h3 class="fw-bold mb-0">$12,450</h3>
                        <small class="text-success"><i class="bi bi-arrow-up-short"></i> +15% from last month</small>
                    </div>
                    <div class="stats-icon bg-light-primary">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <div class="card p-3 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">New Users</p>
                            <h3 class="fw-bold mb-0">342</h3>
                            <small class="text-success"><i class="bi bi-arrow-up-short"></i> +5% new registrations</small>
                        </div>
                        <div class="stats-icon bg-light-success">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <div class="card p-3 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Pending Requests</p>
                            <h3 class="fw-bold mb-0">12</h3>
                            <small class="text-danger"><i class="bi bi-exclamation-circle"></i> Requires attention</small>
                        </div>
                        <div class="stats-icon bg-light-warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-activity me-2"></i> Recent Activity
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">Action</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="https://ui-avatars.com/api/?name=John+Doe&background=random" class="rounded-circle me-2" alt="UD" width="24" height="24"> John Doe</td>
                                <td>Purchased Subscription</td>
                                <td>2 mins ago</td>
                                <td><span class="badge bg-success rounded-pill">Completed</span></td>
                            </tr>
                            <tr>
                                <td><img src="https://ui-avatars.com/api/?name=Jane+Smith&background=random" class="rounded-circle me-2" alt="JS" width="24" height="24"> Jane Smith</td>
                                <td>Updated Profile</td>
                                <td>1 hour ago</td>
                                <td><span class="badge bg-info rounded-pill">Updated</span></td>
                            </tr>
                            <tr>
                                <td><img src="https://ui-avatars.com/api/?name=Robert+Brown&background=random" class="rounded-circle me-2" alt="RB" width="24" height="24"> Robert Brown</td>
                                <td>Refund Request</td>
                                <td>3 hours ago</td>
                                <td><span class="badge bg-warning rounded-pill">Pending</span></td>
                            </tr>
                             <tr>
                                <td><img src="https://ui-avatars.com/api/?name=Alice+Green&background=random" class="rounded-circle me-2" alt="AG" width="24" height="24"> Alice Green</td>
                                <td>Login Failure</td>
                                <td>5 hours ago</td>
                                <td><span class="badge bg-danger rounded-pill">Failed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="#" class="text-decoration-none text-muted small">View All Activity</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-pie-chart me-2"></i> Storage Usage
                </div>
                <div class="card-body">
                    <h5 class="fw-bold">75% Used</h5>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="text-muted small mb-0">15 GB of 20 GB used. Consider upgrading your plan.</p>
                </div>
            </div>
             <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-stars"></i> Pro Tip</h5>
                    <p class="card-text small">Customize this dashboard by editing <code>home.blade.php</code>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
