@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h4 class="fw-bold text-dark">Admission Fee Payment</h4>
                    <p class="text-muted small">Please complete payment to activate your account</p>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h2 class="display-4 fw-bold text-primary">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</h2>
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mt-2">
                            <i class="bi bi-clock me-1"></i> Awaiting Payment
                        </span>
                    </div>

                    <div class="bg-light p-3 rounded-3 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Invoice ID:</span>
                            <span class="fw-bold">INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">For:</span>
                            <span class="fw-bold">{{ $invoice->title }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Due Date:</span>
                            <span class="fw-bold text-danger">{{ $invoice->due_date->format('d M Y') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('student.enrollment.storeStep3') }}" method="POST">
                        @csrf
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-3 fw-bold shadow-sm">
                                <i class="bi bi-credit-card me-2"></i> Pay Now (Mock)
                            </button>
                            <button type="button" class="btn btn-outline-secondary rounded-3">
                                <i class="bi bi-download me-2"></i> Download Invoice
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light border-0 text-center py-3 rounded-bottom-4">
                    <small class="text-muted"><i class="bi bi-lock-fill me-1"></i> Secure Payment by SALUT Indo Global</small>
                </div>
            </div>
            <div class="text-center mt-3 text-muted small">
                Step 3 of 3: Payment
            </div>
        </div>
    </div>
</div>
@endsection
