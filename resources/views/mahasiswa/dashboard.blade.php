@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary text-white overflow-hidden rounded-4 position-relative">
                <div class="card-body p-5 position-relative z-1">
                    <h2 class="fw-bold">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="lead mb-0">Here's your academic and activity overview.</p>
                </div>
                <!-- Abstract Background Shapes -->
                <div class="position-absolute end-0 top-0 h-100 w-50" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1)); clip-path: polygon(20% 0%, 100% 0, 100% 100%, 0% 100%);"></div>
            </div>
        </div>
    </div>

    <!-- Student Details -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center">
                    <small class="text-muted d-block fw-bold text-uppercase">NIM</small>
                    <span class="fs-5 fw-bold text-dark">{{ Auth::user()->nim ?? '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center">
                    <small class="text-muted d-block fw-bold text-uppercase">Fakultas</small>
                    <span class="fs-5 fw-bold text-dark">{{ Auth::user()->faculty ?? '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center">
                    <small class="text-muted d-block fw-bold text-uppercase">Jurusan</small>
                    <span class="fs-5 fw-bold text-dark">{{ Auth::user()->major ?? '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center">
                     <small class="text-muted d-block fw-bold text-uppercase">Semester</small>
                    <span class="fs-5 fw-bold text-primary">{{ Auth::user()->semester ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Tabs -->
    <ul class="nav nav-pills nav-fill mb-4 bg-white p-2 rounded-4 shadow-sm" id="dashboardTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill fw-bold" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academic" type="button" role="tab">Academic Module</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill fw-bold" id="non-academic-tab" data-bs-toggle="tab" data-bs-target="#non-academic" type="button" role="tab">Non-Academic (LayKep)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill fw-bold" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance" type="button" role="tab">Finance</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="dashboardTabContent">
        
        <!-- Academic Module -->
        <div class="tab-pane fade show active" id="academic" role="tabpanel">
            <div class="row g-4">
                <!-- Grades Summary -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold mb-0 text-primary">Academic Records</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Semester</th>
                                            <th>SKS</th>
                                            <th>IPS</th>
                                            <th>IPK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($academicRecords as $record)
                                        <tr>
                                            <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $record->semester }}</span></td>
                                            <td>{{ $record->sks }}</td>
                                            <td>{{ number_format($record->ips ?? 0, 2) }}</td>
                                            <td class="fw-bold">{{ number_format($record->ipk, 2) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No records found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tutorial Schedule -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold mb-0 text-primary">Tutorial Schedule</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @forelse($schedules as $schedule)
                                <li class="list-group-item border-0 ps-0 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-dark">{{ $schedule->course_name }}</h6>
                                        <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ $schedule->day }}, {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</small>
                                    </div>
                                    @if($schedule->link)
                                    <a href="{{ $schedule->link }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle"><i class="bi bi-camera-video"></i></a>
                                    @endif
                                </li>
                                @empty
                                <li class="text-center text-muted py-3">No upcoming tutorials.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Exam Card -->
                <div class="col-12">
                     <div class="card border-0 shadow-sm rounded-4 bg-light">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="fw-bold mb-1">Exam Card (Kartu Ujian)</h5>
                                <p class="mb-0 text-muted small">Download your exam card for the ongoing semester.</p>
                            </div>
                            <button class="btn btn-primary rounded-pill"><i class="bi bi-printer me-2"></i> Print Card</button>
                        </div>
                     </div>
                </div>
            </div>
        </div>

        <!-- Non-Academic Module -->
        <div class="tab-pane fade" id="non-academic" role="tabpanel">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                         <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="bi bi-collection-play display-4 text-warning"></i>
                            </div>
                            <h4 class="fw-bold">Learning Management System (LMS)</h4>
                            <p class="text-muted">Access E-books and Video Materials for your selected track.</p>
                            <button class="btn btn-warning text-white rounded-pill px-4 fw-bold">Enter LMS <i class="bi bi-arrow-right-short"></i></button>
                         </div>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                         <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="bi bi-calendar-range display-4 text-info"></i>
                            </div>
                            <h4 class="fw-bold">Training Calendar</h4>
                            <p class="text-muted">View upcoming webinars and skills training schedules.</p>
                            <button class="btn btn-info text-white rounded-pill px-4 fw-bold">View Calendar <i class="bi bi-calendar"></i></button>
                         </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Finance Module -->
        <div class="tab-pane fade" id="finance" role="tabpanel">
             <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-primary">Financial History</h5>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill">Download Report</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                         <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $inv)
                                <tr>
                                    <td>#INV-{{ str_pad($inv->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="fw-bold">{{ $inv->title }}</td>
                                    <td>Rp {{ number_format($inv->amount, 0, ',', '.') }}</td>
                                    <td>{{ $inv->due_date->format('d M Y') }}</td>
                                    <td>
                                        @if($inv->status == 'paid')
                                            <span class="badge bg-success rounded-pill px-3">Paid</span>
                                        @elseif($inv->status == 'unpaid')
                                            <span class="badge bg-danger rounded-pill px-3">Unpaid</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">{{ ucfirst($inv->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($inv->status == 'unpaid')
                                        <button class="btn btn-sm btn-primary rounded-pill px-3">Pay</button>
                                        @else
                                        <a href="{{ route('student.invoice.print', $inv->id) }}" target="_blank" class="btn btn-sm btn-light rounded-circle" title="Download Invoice">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">No payment history found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                         </table>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection
