@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary fw-bold">Data Mahasiswa Aktif</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Jurusan</th>
                                <th>Semester</th>
                                <th class="text-center">IPK</th>
                                <th>Kategori</th>
                                <th>Program Unggulan</th>
                                <th class="text-center">WA</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                                <td class="fw-bold">{{ $student->nim ?? '-' }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->major ?? $student->registration->prodi ?? '-' }}</td>
                                <td>{{ $student->semester ?? 1 }}</td>
                                <td class="text-center fw-bold text-primary">{{ $student->ipk ?? '0.00' }}</td>
                                <td>
                                    @if($student->registration)
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-primary rounded-pill w-auto align-self-start">{{ $student->registration->jenjang }}</span>
                                            <span class="badge bg-success rounded-pill w-auto align-self-start">{{ $student->registration->jalur_pendaftaran }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $fokus = $student->registration->fokus_karir ?? '-';
                                        $icon = '';
                                        $colorClass = 'text-secondary';
                                        
                                        if(str_contains($fokus, 'Wirausaha')) {
                                            $icon = 'bi-rocket-takeoff-fill';
                                            $colorClass = 'text-success'; 
                                        } elseif(str_contains($fokus, 'Magang')) {
                                            $icon = 'bi-building-fill';
                                            $colorClass = 'text-primary'; 
                                        } elseif(str_contains($fokus, 'Creator') || str_contains($fokus, 'Affiliator')) {
                                            $icon = 'bi-phone-fill';
                                            $colorClass = 'text-warning'; 
                                        } elseif(str_contains($fokus, 'Skill')) {
                                            $icon = 'bi-laptop';
                                            $colorClass = 'text-info'; 
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center fw-bold {{ $colorClass }}">
                                        @if($icon) <i class="bi {{ $icon }} me-2 fs-5"></i> @endif
                                        {{ $fokus }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $wa = $student->registration->whatsapp ?? '-';
                                        $hasWa = false;
                                        $waLink = '#';

                                        if ($wa && $wa !== '-') {
                                            $waClean = preg_replace('/[^0-9]/', '', $wa);
                                            if(str_starts_with($waClean, '0')) {
                                                $waClean = '62' . substr($waClean, 1);
                                            }
                                            $waLink = "https://api.whatsapp.com/send?phone={$waClean}&text=Halo%20kak!%20Terimakasih%20telah%20daftar%20di%20SALUT%20INDO%20GLOBAL%F0%9F%98%8A";
                                            $hasWa = true;
                                        }
                                    @endphp
                                    @if($hasWa)
                                        <a href="{{ $waLink }}" target="_blank" class="btn btn-sm btn-success rounded-circle" title="Chat WhatsApp">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $student->id }}" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.users.edit', $student->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-3"></i>
                                    Belum ada data mahasiswa aktif.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Use section for modals to keep loop clean if needed, or inline loop here -->
@foreach($students as $student)
<div class="modal fade" id="detailModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-person-badge me-2"></i>Detail Mahasiswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Identitas -->
                    <div class="col-md-12">
                        <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">Identitas Diri</h6>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">NIM</label>
                        <div class="fw-bold">{{ $student->nim ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Nama Lengkap</label>
                        <div class="fw-bold">{{ $student->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Email</label>
                        <div>{{ $student->email }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Status</label>
                        <div>
                            @if($student->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($student->status) }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Akademik -->
                    <div class="col-md-12 mt-4">
                        <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">Data Akademik</h6>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Fakultas</label>
                        <div>{{ $student->faculty ?? $student->registration->fakultas ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Jurusan / Prodi</label>
                        <div>{{ $student->major ?? $student->registration->prodi ?? '-' }}</div>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small">Semester</label>
                        <div>{{ $student->semester ?? 1 }}</div>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small">IPK</label>
                        <div class="fw-bold text-primary">{{ $student->ipk ?? '0.00' }}</div>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small">Angkatan</label>
                        <div><span class="badge bg-dark">{{ $student->angkatan ?? $student->created_at->format('Y') }}</span></div>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small">Jenjang</label>
                        <div><span class="badge bg-primary">{{ $student->registration->jenjang ?? '-' }}</span></div>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small">Jalur</label>
                        <div><span class="badge bg-info text-dark">{{ $student->registration->jalur_pendaftaran ?? '-' }}</span></div>
                    </div>

                    <!-- Informasi Akun Kampus -->
                    <div class="col-md-12 mt-4">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="text-dark fw-bold mb-3"><i class="bi bi-shield-lock me-2"></i>Akun MyUT</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-muted small">Password MyUT</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control bg-white" value="{{ $student->password_myut ?? '' }}" readonly id="myut-pass-{{ $student->id }}">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('myut-pass-{{ $student->id }}')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted fst-italic">*Rahasiakan data ini</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="col-md-12 mt-4">
                        <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">Kontak Cepat</h6>
                    </div>
                    <div class="col-md-12">
                        @php
                            $wa = $student->registration->whatsapp ?? '';
                            $waDisplay = $wa; // Keep original for display
                            // Remove non-numeric
                            $waClean = preg_replace('/[^0-9]/', '', $wa);
                            // If starts with 0, replace with 62
                            if(str_starts_with($waClean, '0')) {
                                $waClean = '62' . substr($waClean, 1);
                            }
                        @endphp
                        @if($wa)
                            <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-light">
                                <div>
                                    <label class="text-muted small d-block mb-1">Nomor WhatsApp</label>
                                    <span class="fs-5 fw-bold text-dark">{{ $waDisplay }}</span>
                                </div>
                                <a href="https://wa.me/{{ $waClean }}?text=Halo%20kak!%20Terimakasih%20telah%20daftar%20di%20SALUT%20INDO%20GLOBAL%F0%9F%98%8A" target="_blank" class="btn btn-success">
                                    <i class="bi bi-whatsapp me-2"></i> Chat Sekarang
                                </a>
                            </div>
                        @else
                            <button class="btn btn-secondary w-100" disabled>Nomor WA Tidak Tersedia</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    function togglePassword(id) {
        var input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
</script>
@endsection
