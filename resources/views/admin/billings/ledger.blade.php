@extends('layouts.admin')

@section('title', 'Kartu Kontrol Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Kartu Kontrol Pembayaran (Ledger)</h1>
            <p class="text-muted mb-0">Riwayat dan Kontrol Pembayaran Mahasiswa</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Mahasiswa
        </a>
    </div>

    <!-- Student Info Card -->
    <div class="card shadow-sm border-0 mb-4 border-start border-primary border-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <div class="avatar bg-light rounded-circle p-3 d-inline-block">
                        <i class="bi bi-person-fill fs-2 text-primary"></i>
                    </div>
                </div>
                <div class="col-md-8">
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <div class="d-flex flex-wrap gap-3 text-muted">
                        <small><i class="bi bi-card-text me-1"></i> NIM: <strong>{{ $user->nim ?? '-' }}</strong></small>
                        <small><i class="bi bi-mortarboard me-1"></i> Prodi: <strong>{{ $user->registration->prodi ?? '-' }}</strong></small>
                        <small><i class="bi bi-calendar-event me-1"></i> Angkatan: <strong>{{ $user->angkatan ?? '-' }}</strong></small>
                        <small><i class="bi bi-bookmark-star me-1"></i> Semester Saat Ini: <span class="badge bg-warning text-dark">Semester {{ $user->semester }}</span></small>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-outline-primary btn-sm" onclick="toggleLock()">
                        <i class="bi bi-unlock me-1"></i> Buka Kunci (Admin)
                    </button>
                    <button class="btn btn-outline-success btn-sm ms-2" onclick="addSemester()">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Semester
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ledger Table (Split View) -->
    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th style="width: 5%;">Smt</th>
                            <th class="bg-primary text-white" style="width: 47%;">
                                <i class="bi bi-wallet2 me-1"></i> UKT (Uang Kuliah Tunggal)
                            </th>
                            <th class="bg-orange text-white" style="width: 47%; background-color: #fd7e14;">
                                <i class="bi bi-building me-1"></i> Layanan SALUT
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= $maxSemester; $i++)
                            @php
                                $isCurrent = ($i == $user->semester);
                                $isFuture = ($i > $user->semester);
                                
                                // Safely get bills for this semester
                                $semesterBills = $billings->get($i, collect());
                                
                                // Find bills
                                $uktBill = $semesterBills->firstWhere('category', 'UKT');
                                $salutBill = $semesterBills->firstWhere('category', 'Layanan SALUT');
                            @endphp
                            
                            <tr class="semester-row {{ $isCurrent ? 'table-warning border-3 border-warning fw-bold' : '' }}" data-semester="{{ $i }}">
                                <td class="text-center fw-bold fs-5">{{ $i }}</td>
                                
                                <!-- UKT Column (ALWAYS UNLOCKED) -->
                                <td class="p-3 position-relative">
                                    @if($uktBill)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="small text-muted">{{ $uktBill->billing_code }}</div>
                                                <div class="fs-5">Rp {{ number_format($uktBill->amount, 0, ',', '.') }}</div>
                                                <small class="text-muted">Tenggat: {{ $uktBill->due_date ? $uktBill->due_date->format('d M Y') : '-' }}</small>
                                            </div>
                                            <div class="text-end">
                                                @if($uktBill->status == 'paid')
                                                    <span class="badge bg-success mb-2 d-block"><i class="bi bi-check-circle me-1"></i> LUNAS</span>
                                                    <a href="{{ route('admin.billings.print', $uktBill->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer"></i></a>
                                                @elseif($uktBill->status == 'pending')
                                                     <span class="badge bg-warning text-dark mb-2 d-block">Menunggu Verifikasi</span>
                                                     <a href="{{ route('admin.billings.verification') }}" class="btn btn-sm btn-warning">Cek Status</a>
                                                @else
                                                    <span class="badge bg-danger mb-2 d-block">Belum Bayar</span>
                                                    <!-- Manuel Verify Button -->
                                                    <button class="btn btn-sm btn-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#payBillModal" 
                                                        onclick="setupPayBill('{{ $uktBill->id }}', 'UKT')">
                                                        <i class="bi bi-credit-card me-1"></i> Verifikasi Manual
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <!-- No Bill: Allow creation for ANY semester (Future or Past) -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted fst-italic">Belum ada tagihan</span>
                                            <button class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#createBillModal" 
                                                onclick="setupCreateBill({{ $i }}, 'UKT')">
                                                <i class="bi bi-plus-lg me-1"></i> Buat Tagihan UKT
                                            </button>
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Salut Column (Keep Locked logic for future if desired, OR unlock broadly. I'll keep default lock behavior for SALUT if user only specified UKT, but removing row lock makes it accessible unless I enforce cell lock) -->
                                <!-- I will re-apply locked visual to SALUT specifically if future, since user said 'khusus ukt' -->
                                <td class="p-3 position-relative {{ $isFuture ? 'bg-light' : '' }}">
                                    @if($salutBill)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                 <div class="small text-muted">{{ $salutBill->billing_code }}</div>
                                                <div class="fs-5">Rp {{ number_format($salutBill->amount, 0, ',', '.') }}</div>
                                                <small class="text-muted">Tenggat: {{ $salutBill->due_date ? $salutBill->due_date->format('d M Y') : '-' }}</small>
                                            </div>
                                            <div class="text-end">
                                                @if($salutBill->status == 'paid')
                                                    <span class="badge bg-success mb-2 d-block"><i class="bi bi-check-circle me-1"></i> LUNAS</span>
                                                     <a href="{{ route('admin.billings.print', $salutBill->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer"></i></a>
                                                @elseif($salutBill->status == 'pending')
                                                     <span class="badge bg-warning text-dark mb-2 d-block">Menunggu Verifikasi</span>
                                                     <a href="{{ route('admin.billings.verification') }}" class="btn btn-sm btn-warning">Cek Status</a>
                                                @else
                                                    <span class="badge bg-danger mb-2 d-block">Belum Bayar</span>
                                                    <button class="btn btn-sm btn-warning text-white" 
                                                        style="background-color: #fd7e14; border-color: #fd7e14;" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#payBillModal" 
                                                        onclick="setupPayBill('{{ $salutBill->id }}', 'Layanan SALUT')">
                                                        <i class="bi bi-credit-card me-1"></i> Verifikasi Manual
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <!-- No Bill -->
                                        @if(!$isFuture)
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted fst-italic">Belum ada tagihan</span>
                                                <button class="btn btn-sm text-white" 
                                                    style="background-color: #fd7e14; border-color: #fd7e14;" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#createBillModal" 
                                                    onclick="setupCreateBill({{ $i }}, 'Layanan SALUT')">
                                                    <i class="bi bi-plus-lg me-1"></i> Buat Tagihan Adm
                                                </button>
                                            </div>
                                        @else
                                             <div class="text-center small text-muted"><i class="bi bi-lock-fill me-1"></i> Terkunci (SALUT)</div>
                                        @endif
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

<!-- Modal Create Bill -->
<div class="modal fade" id="createBillModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.billings.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="semester" id="modalSemester">
            <input type="hidden" name="category" id="modalCategory">
            
            <div class="modal-header">
                <h5 class="modal-title">Buat Tagihan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" class="form-control" id="displayCategory" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Semester</label>
                    <input type="text" class="form-control" id="displaySemester" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nominal (Rp)</label>
                    <input type="number" name="amount" class="form-control" required min="0">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tenggat Pembayaran</label>
                    <input type="date" name="due_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan & Buat Tagihan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Pay Manual / Verification -->
<div class="modal fade" id="payBillModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="payForm" action="" method="POST" class="modal-content">
            @csrf
            @method('PUT') 
            
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-check-circle me-1"></i> Verifikasi Pembayaran Manual</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info small mb-3">
                    <i class="bi bi-info-circle-fill me-1"></i> Pastikan dana sudah diterima sebelum melakukan verifikasi ini.
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Pembayaran</label>
                    <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">No. Referensi / LIP / Bukti Transfer</label>
                    <input type="text" name="reference_number" class="form-control" placeholder="Contoh: TRANSFER-BCA-123456" required>
                    <small class="text-muted">Masukkan kode unik transaksi atau nomor kuitansi manual.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan Admin (Opsional)</label>
                    <textarea name="admin_note" class="form-control" rows="2" placeholder="Contoh: Diterima Cash oleh Staff A"></textarea>
                </div>

                <hr>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" required id="confirmCheck">
                    <label class="form-check-label small text-muted" for="confirmCheck">
                        Saya menyatakan data di atas benar dan dana telah diterima.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan & Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .locked-row {
        opacity: 0.6;
        background-color: #f8f9fa; /* visual gray */
    }
    /* Only disable interaction if NOT unlocked */
    .locked-row:not(.unlocked) {
        pointer-events: none;
    }
    
    .locked-row.unlocked {
        opacity: 1;
        pointer-events: auto !important;
        border: 2px dashed #0d6efd; /* Visual indicator that it's forcibly opened */
    }
    
    .border-thick {
        border-width: 3px !important;
    }
</style>

@push('scripts')
<script>
    function toggleLock() {
        const rows = document.querySelectorAll('.locked-row');
        rows.forEach(row => {
            row.classList.toggle('unlocked');
        });
        
        // Update button text logic if desired
    }

    function setupCreateBill(semester, category) {
        document.getElementById('modalSemester').value = semester;
        document.getElementById('displaySemester').value = semester;
        document.getElementById('modalCategory').value = category;
        document.getElementById('displayCategory').value = category;
        
        // Modal opens via data-bs-toggle
    }

    function setupPayBill(id, category) {
        // Use manual verify route
        const form = document.getElementById('payForm');
        form.action = `{{ url('admin/billings') }}/${id}/manual-verify`;  
        
        // Modal opens via data-bs-toggle
    }
    
    function addSemester() {
        alert("Fitur tambah semester otomatis akan menambah baris ke tabel.");
    }
</script>
@endpush
@endsection
