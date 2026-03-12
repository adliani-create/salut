@extends('layouts.admin')

@section('title', 'Manajemen Dokumen (KTPU & KTM)')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manajemen Dokumen Mahasiswa</h2>
        <div>
           <!-- Reserved for future bulk actions -->
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
             <!-- Search Bar using standard custom layout pattern -->
            <form action="{{ route('admin.documents.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari berdasarkan Nama atau NIM mahasiswa..." value="{{ request('search') }}">
                    <button class="btn btn-primary px-4" type="submit">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary px-3" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>

            <ul class="nav nav-tabs mb-4" id="documentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="ktpu-tab" data-bs-toggle="tab" data-bs-target="#ktpu-pane" type="button" role="tab" aria-controls="ktpu-pane" aria-selected="true">
                        <i class="bi bi-file-earmark-pdf text-danger me-1"></i>Kelola KTPU
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="ktm-tab" data-bs-toggle="tab" data-bs-target="#ktm-pane" type="button" role="tab" aria-controls="ktm-pane" aria-selected="false">
                        <i class="bi bi-person-badge text-primary me-1"></i>Kelola KTM
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="documentTabsContent">
                <!-- Tab KTPU -->
                <div class="tab-pane fade show active" id="ktpu-pane" role="tabpanel" aria-labelledby="ktpu-tab" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Program Studi / Smt</th>
                                    <th class="text-center">Status KTPU</th>
                                    <th class="text-center">Dokumen KTPU</th>
                                    <th>Aksi Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                     <td><span class="fw-bold text-dark">{{ $student->nim ?? '-' }}</span></td>
                                     <td>
                                         <div class="fw-bold text-primary">{{ $student->name }}</div>
                                     </td>
                                     <td>
                                         <div class="small">{{ $student->major ?? '-' }}</div>
                                         <span class="badge bg-secondary border border-secondary text-white">Smt {{ $student->semester ?? '-' }}</span>
                                     </td>
                                     <td class="text-center">
                                         @if($student->ktpu_status === 'tersedia')
                                             <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Tersedia</span>
                                         @else
                                             <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="bi bi-clock-history me-1"></i> Pending</span>
                                         @endif
                                     </td>
                                     <td class="text-center">
                                          @if($student->ktpu_file)
                                              <a href="{{ Storage::url($student->ktpu_file) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill fw-bold mb-1">
                                                  <i class="bi bi-eye"></i> Lihat KTPU
                                              </a>
                                          @else
                                              <span class="text-muted small d-block mb-1">Belum ada</span>
                                          @endif
                                          <button type="button" class="btn btn-sm btn-primary rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#uploadModalKtpu{{ $student->id }}">
                                               <i class="bi bi-upload"></i> Unggah KTPU
                                          </button>
                                     </td>
                                     <td>
                                         @if($student->ktpu_status === 'tersedia')
                                            <form action="{{ route('admin.documents.toggle-status', $student->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Tarik Kembali Akses (Set Pending)">
                                                    <i class="bi bi-x-circle me-1"></i>Sembunyikan
                                                </button>
                                            </form>
                                         @else
                                            <form action="{{ route('admin.documents.toggle-status', $student->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="tersedia">
                                                <button type="submit" class="btn btn-sm btn-outline-success" {{ !$student->ktpu_file ? 'disabled' : '' }} title="Buka Akses Cetak (Set Tersedia)">
                                                    <i class="bi bi-check-circle me-1"></i>Munculkan
                                                </button>
                                            </form>
                                         @endif
                                     </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                         <i class="bi bi-folder-x fs-1 d-block mb-3 text-opacity-50 text-secondary"></i>
                                         Tidak ada mahasiswa yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab KTM -->
                <div class="tab-pane fade" id="ktm-pane" role="tabpanel" aria-labelledby="ktm-tab" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Program Studi / Smt</th>
                                    <th class="text-center">Preview Kustom</th>
                                    <th class="text-center">Unggah Baru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                     <td><span class="fw-bold text-dark">{{ $student->nim ?? '-' }}</span></td>
                                     <td>
                                         <div class="fw-bold text-primary">{{ $student->name }}</div>
                                     </td>
                                     <td>
                                         <div class="small">{{ $student->major ?? '-' }}</div>
                                         <span class="badge bg-secondary border border-secondary text-white">Smt {{ $student->semester ?? '-' }}</span>
                                     </td>
                                     <td class="text-center">
                                          @if($student->ktm_file)
                                              <a href="{{ Storage::url($student->ktm_file) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill fw-bold">
                                                  <i class="bi bi-eye"></i> Lihat KTM
                                              </a>
                                          @else
                                              <span class="text-muted small">File Kustom Belum Ada</span>
                                          @endif
                                     </td>
                                     <td class="text-center">
                                          <button type="button" class="btn btn-sm btn-primary rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#uploadModalKtm{{ $student->id }}">
                                               <i class="bi bi-upload"></i> Unggah KTM
                                          </button>
                                     </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                         <i class="bi bi-folder-x fs-1 d-block mb-3 text-opacity-50 text-secondary"></i>
                                         Tidak ada mahasiswa yang ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $students->links('vendor.pagination.custom') }}
            </div>

        </div>
    </div>
</div>
@endsection

@push('modals')
    @foreach($students as $student)
    <!-- KTPU Modal -->
    <div class="modal fade text-start" id="uploadModalKtpu{{ $student->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('admin.documents.upload-ktpu', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0 bg-light rounded-top-4 py-3">
                        <h5 class="modal-title fw-bold text-primary">Unggah KTPU untuk {{ explode(' ', trim($student->name))[0] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih File PDF KTPU</label>
                            <input class="form-control" type="file" name="ktpu_file" accept=".pdf" required>
                            <div class="form-text">Maksimal ukuran file 2MB, format .pdf</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 pe-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Unggah & Aktifkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- KTM Modal -->
    <div class="modal fade text-start" id="uploadModalKtm{{ $student->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('admin.documents.upload-ktm', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0 bg-light rounded-top-4 py-3">
                        <h5 class="modal-title fw-bold text-primary">Unggah KTM Kustom untuk {{ explode(' ', trim($student->name))[0] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih File KTM (PDF/JPG/PNG)</label>
                            <input class="form-control" type="file" name="ktm_file" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">Maksimal ukuran file 2MB. Jika KTM diunggah, mahasiswa akan mengunduh KTM ini alih-alih file System Generate.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 pe-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Unggah & Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endpush
