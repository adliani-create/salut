@extends('layouts.student')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark">Module Akademik</h3>
    <p class="text-muted">Riwayat nilai dan layanan akademik Anda.</p>
</div>

<div class="row g-4">
    <!-- Grades Summary -->
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0 text-primary">Academic Records (Transkrip)</h5>
            </div>
            <div class="card-body">
                <!-- Desktop View -->
                <div class="table-responsive d-none d-md-block">
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

                <!-- Mobile View (Card List) -->
                <div class="d-block d-md-none">
                    @forelse($academicRecords as $record)
                    <div class="card border shadow-sm rounded-3 mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary fs-6">{{ $record->semester }}</span>
                            </div>
                            <div class="row text-center mt-3">
                                <div class="col-4 border-end">
                                    <small class="text-muted d-block small">SKS</small>
                                    <span class="fw-bold">{{ $record->sks }}</span>
                                </div>
                                <div class="col-4 border-end">
                                    <small class="text-muted d-block small">IPS</small>
                                    <span class="fw-bold">{{ number_format($record->ips ?? 0, 2) }}</span>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block small">IPK</small>
                                    <span class="fw-bold text-primary">{{ number_format($record->ipk, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-journal-x fs-1 opacity-50"></i>
                        <div class="small mt-2">No records found.</div>
                    </div>
                    @endforelse
                </div>
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
@endsection
