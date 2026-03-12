@extends('layouts.admin')

@section('title', 'Registrasi Mahasiswa')

@section('content')
@section('content')
<div class="row">
    <div class="col-md-12">
        
        <!-- Header & Search -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold m-0 text-dark">Registrasi Mahasiswa</h4>
                <div class="text-muted small">Verifikasi pendaftaran mahasiswa baru.</div>
            </div>
            <div>
                <form action="{{ route('admin.registrations.index') }}" method="GET">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white" style="width: 450px;">
                        <span class="input-group-text bg-white border-0 ps-3 pe-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="q" class="form-control border-0 ps-2" placeholder="Cari Nama atau Email..." value="{{ $search ?? '' }}">
                        <button class="btn btn-primary px-4 fw-bold" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <!-- Removed Card Header Title since we have Page Header now -->
            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Program</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $reg)
                            <tr>
                                <td class="fw-medium">{{ $reg->user ? $reg->user->name : 'N/A' }}</td>
                                <td>{{ $reg->prodi ?? '-' }}</td>
                                <td>{{ $reg->fokus_karir ?? '-' }}</td>
                                <td>
                                    @if($reg->status == 'pending')
                                        <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                                    @elseif($reg->status == 'valid')
                                        <span class="badge bg-success rounded-pill px-3">Valid</span>
                                    @elseif($reg->status == 'invalid')
                                        <span class="badge bg-danger rounded-pill px-3">Invalid</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.registrations.show', $reg->id) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($reg->status == 'pending')
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#approveModal{{ $reg->id }}">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-check-circle-fill fs-1 d-block mb-3 text-success"></i>
                                    Tidak ada registrasi baru yang pending.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> <!-- End Table Responsive -->

                <div class="px-4 py-3 border-top">
                    {{ $registrations->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals outside the table -->
@foreach($registrations as $reg)
    @if($reg->status == 'pending')
    <div class="modal fade" id="approveModal{{ $reg->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.registrations.approve', $reg->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Approval & Lengkapi Data Mahasiswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $reg->user->name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $reg->user->email }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor WhatsApp</label>
                                <input type="text" class="form-control" value="{{ $reg->whatsapp }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                                <input type="text" name="nim" class="form-control" required placeholder="Masukkan NIM Baru">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fakultas</label>
                                <input type="text" name="faculty" class="form-control" value="{{ $reg->fakultas }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jurusan / Prodi</label>
                                <input type="text" name="major" class="form-control" value="{{ $reg->prodi }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Semester</label>
                                <input type="number" name="semester" class="form-control" value="1" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenjang</label>
                                <input type="text" class="form-control" value="{{ $reg->jenjang }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jalur</label>
                                <input type="text" class="form-control" value="{{ $reg->jalur_pendaftaran }}" readonly>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Data ini akan disimpan ke profil pengguna dan status akan berubah menjadi <strong>Active</strong>.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            Simpan & Terima Mahasiswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection
