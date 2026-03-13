@extends('layouts.admin')

@section('title', 'Registrasi Mahasiswa')

@section('content')
<div class="row">
    <div class="col-md-12 p-4">
        
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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
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

@endsection
