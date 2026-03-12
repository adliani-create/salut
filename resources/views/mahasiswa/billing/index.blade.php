@extends('layouts.student')

@section('title', 'Billing & Keuangan')

@section('content')
<div class="container-fluid py-2">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3 class="fw-bold mb-4 text-primary"><i class="bi bi-wallet2 me-2"></i>Kartu Kontrol Pembayaran</h3>
            
            <div class="card shadow border-0">
                <div class="card-header bg-white p-0 border-bottom-0">
                    <ul class="nav nav-tabs nav-justified" id="billingTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-3 fw-bold" id="ukt-tab" data-bs-toggle="tab" data-bs-target="#ukt-pane" type="button" role="tab" aria-controls="ukt-pane" aria-selected="true">
                                <i class="bi bi-mortarboard me-2"></i>UKT Universitas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 fw-bold" id="salut-tab" data-bs-toggle="tab" data-bs-target="#salut-pane" type="button" role="tab" aria-controls="salut-pane" aria-selected="false">
                                <i class="bi bi-building me-2"></i>Layanan SALUT
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="tab-content" id="billingTabsContent">
                        
                        <!-- TAB UKT (Read Only) -->
                        <div class="tab-pane fade show active" id="ukt-pane" role="tabpanel" aria-labelledby="ukt-tab">
                            <div class="alert alert-info border-0 d-flex align-items-center mb-4">
                                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                                <div>
                                    <strong>Informasi UKT</strong>
                                    <br>Tagihan ini dibayar langsung ke rekening Universitas (Pusat). Status di sini hanya untuk monitoring.
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 10%;">Smt</th>
                                            <th>Keterangan</th>
                                            <th style="width: 25%;">Nominal</th>
                                            <th style="width: 20%;">Status</th>
                                            <th style="width: 20%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= $maxSemester; $i++)
                                            @php
                                                $semesterBills = $billings->get($i, collect());
                                                $uktBill = $semesterBills->firstWhere('category', 'UKT');
                                                $isCurrent = ($i == $user->semester);
                                            @endphp
                                            <tr class="{{ $isCurrent ? 'table-primary border-start border-4 border-primary' : '' }}">
                                                <td class="text-center fw-bold">{{ $i }}</td>
                                                <td>
                                                    UKT Semester {{ $i }}
                                                    @if($isCurrent) <span class="badge bg-primary ms-1">Aktif</span> @endif
                                                </td>
                                                <td class="fw-bold">
                                                    {{ $uktBill ? 'Rp ' . number_format($uktBill->amount, 0, ',', '.') : '-' }}
                                                </td>
                                                <td>
                                                    @if($uktBill && $uktBill->status == 'paid')
                                                        <span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> LUNAS</span>
                                                    @elseif($uktBill)
                                                        <span class="text-danger fw-bold"><i class="bi bi-x-circle-fill me-1"></i> BELUM LUNAS</span>
                                                    @else
                                                        <span class="text-muted small">Belum ada data</span>
                                                    @endif
                                                </td>
                                                <td class="text-center text-muted small">
                                                    - (Cek Web Pusat) -
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- TAB SALUT (Actionable) -->
                        <div class="tab-pane fade" id="salut-pane" role="tabpanel" aria-labelledby="salut-tab">
                            <div class="alert alert-warning border-0 d-flex align-items-center mb-4 text-dark" style="background-color: #fff3cd;">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-4 text-warning"></i>
                                <div>
                                    <strong>Tagihan Layanan SALUT</strong>
                                    <br>Dikelola oleh SALUT INDO GLOBAL. Silakan download tagihan dan lakukan pembayaran sesuai instruksi.
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 10%;">Smt</th>
                                            <th>Keterangan</th>
                                            <th style="width: 25%;">Nominal</th>
                                            <th style="width: 20%;">Status</th>
                                            <th style="width: 20%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= $maxSemester; $i++)
                                            @php
                                                $semesterBills = $billings->get($i, collect());
                                                $salutBill = $semesterBills->firstWhere('category', 'Layanan SALUT');
                                                $isCurrent = ($i == $user->semester);
                                            @endphp
                                            <tr class="{{ $isCurrent ? 'table-warning border-start border-4 border-warning' : '' }}">
                                                <td class="text-center fw-bold">{{ $i }}</td>
                                                <td>
                                                    Layanan SALUT Semester {{ $i }}
                                                    @if($isCurrent) <span class="badge bg-warning text-dark ms-1">Aktif</span> @endif
                                                </td>
                                                <td class="fw-bold">
                                                    {{ $salutBill ? 'Rp ' . number_format($salutBill->amount, 0, ',', '.') : '-' }}
                                                </td>
                                                <td>
                                                    @if($salutBill && $salutBill->status == 'paid')
                                                        <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i> LUNAS</span>
                                                    @elseif($salutBill && $salutBill->status == 'pending')
                                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> MENUNGGU KONFIRMASI</span>
                                                    @elseif($salutBill && $salutBill->status == 'failed')
                                                        <span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i> DITOLAK</span>
                                                    @elseif($salutBill)
                                                        <span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i> BELUM LUNAS</span>
                                                    @else
                                                        <span class="text-muted small">Belum ada tagihan</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($salutBill)
                                                        @if($salutBill->status == 'unpaid')
                                                            <!-- Unpaid: Show Upload Button + Download -->
                                                            <button class="btn btn-sm btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#uploadProofModal" onclick="setUploadAction('{{ $salutBill->id }}')">
                                                                <i class="bi bi-upload me-1"></i> Upload Bukti
                                                            </button>
                                                            <a href="{{ route('student.invoice.print', $salutBill->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary w-100">
                                                                <i class="bi bi-file-earmark-pdf me-1"></i> Download Tagihan
                                                            </a>
                                                            
                                                        @elseif($salutBill->status == 'pending')
                                                            <!-- Pending: Show Info + Download -->
                                                            <div class="text-muted small fst-italic mb-2">
                                                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Admin...
                                                            </div>
                                                            <a href="{{ route('student.invoice.print', $salutBill->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary w-100">
                                                                <i class="bi bi-file-earmark-pdf me-1"></i> Download Tagihan
                                                            </a>

                                                        @elseif($salutBill->status == 'paid')
                                                            <!-- Paid: Download Invoice (Serves as Bill too) -->
                                                             <a href="{{ route('student.invoice.print', $salutBill->id) }}" target="_blank" class="btn btn-sm btn-success w-100">
                                                                <i class="bi bi-printer-fill me-1"></i> Cetak Invoice
                                                            </a>
                                                            
                                                        @elseif($salutBill->status == 'failed')
                                                            <!-- Failed: Re-upload + Download -->
                                                            <div class="mb-1 text-danger small fst-italic">
                                                                "{{ $salutBill->rejection_reason ?? 'Bukti tidak valid' }}"
                                                            </div>
                                                            <button class="btn btn-sm btn-outline-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#uploadProofModal" onclick="setUploadAction('{{ $salutBill->id }}')">
                                                                <i class="bi bi-arrow-repeat me-1"></i> Upload Ulang
                                                            </button>
                                                            <a href="{{ route('student.invoice.print', $salutBill->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary w-100">
                                                                <i class="bi bi-file-earmark-pdf me-1"></i> Download Tagihan
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-center">
            </div>
        </div>
    </div>
</div>

<!-- Upload Payment Proof Modal -->
<div class="modal fade" id="uploadProofModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="uploadForm" action="" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info small mb-3">
                    <i class="bi bi-info-circle me-1"></i> Pastikan foto bukti transfer terlihat jelas dan nominal sesuai tagihan.
                </div>
                <div class="mb-3">
                    <label class="form-label">File Bukti Transfer</label>
                    <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                    <small class="text-muted">Format: JPG, PNG. Maks: 2MB.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i> Kirim Bukti
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function setUploadAction(id) {
        // Set form action dynamically
        const form = document.getElementById('uploadForm');
        form.action = `{{ url('mahasiswa/billing') }}/${id}/upload`;
        
        // Modal is opened via data-bs-toggle on the button, so we don't need JS here
    }
</script>
@endpush
@endsection
