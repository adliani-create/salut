@extends('layouts.admin')

@section('title', 'Edit Data Mahasiswa')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary fw-bold">Edit Data Mahasiswa</h5>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="editStudentForm">
                        @csrf
                        @method('PUT')

                        <!-- Identitas Utama -->
                        <h6 class="text-secondary fw-bold border-bottom pb-2 mb-3">Identitas Utama</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIM <span class="badge bg-secondary ms-1">Readonly</span></label>
                                <input type="text" class="form-control bg-light" value="{{ $user->nim }}" readonly>
                                <div class="form-text text-muted">NIM tidak dapat diubah. Hubungi Super Admin jika perlu revisi.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Mahasiswa</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="graduated" {{ $user->status == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Data Akademik -->
                        <h6 class="text-secondary fw-bold border-bottom pb-2 mb-3">Data Akademik & Program</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Fakultas</label>
                                <input type="text" name="faculty" class="form-control" value="{{ old('faculty', $user->faculty ?? $user->registration->fakultas ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jurusan / Prodi</label>
                                <input type="text" name="major" class="form-control" value="{{ old('major', $user->major ?? $user->registration->prodi ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Semester</label>
                                <input type="number" name="semester" class="form-control" value="{{ old('semester', $user->semester) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">IPK</label>
                                <input type="number" step="0.01" min="0" max="4.00" name="ipk" class="form-control" value="{{ old('ipk', $user->ipk) }}">
                            </div>
                            
                            <!-- Fields from Registration Logic -->
                            <div class="col-md-6">
                                <label class="form-label">Jenjang</label>
                                <select name="jenjang" class="form-select">
                                    <option value="S1" {{ old('jenjang', $user->registration->jenjang ?? '') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('jenjang', $user->registration->jenjang ?? '') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="D3" {{ old('jenjang', $user->registration->jenjang ?? '') == 'D3' ? 'selected' : '' }}>D3</option>
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label">Jalur Pendaftaran</label>
                                <select name="jalur" class="form-select">
                                    <option value="Reguler" {{ old('jalur', $user->registration->jalur_pendaftaran ?? '') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                    <option value="RPL" {{ old('jalur', $user->registration->jalur_pendaftaran ?? '') == 'RPL' ? 'selected' : '' }}>RPL</option>
                                </select>
                            </div>

                             <div class="col-md-12">
                                <label class="form-label fw-bold text-primary">Program Unggulan (Career Focus)</label>
                                <select name="fokus_karir" id="fokus_karir" class="form-select border-primary" onchange="confirmProgramChange(this)">
                                    @foreach(['Kuliah Plus Wirausaha', 'Kuliah Plus Magang Kerja', 'Kuliah Plus Creator / Affiliator', 'Kuliah Plus Skill Academy'] as $prog)
                                        <option value="{{ $prog }}" {{ old('fokus_karir', $user->registration->fokus_karir ?? '') == $prog ? 'selected' : '' }}>{{ $prog }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text text-danger" id="programWarning" style="display:none">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Perhatian: Mengubah program ini mungkin mempengaruhi kurikulum mahasiswa.
                                </div>
                            </div>
                        </div>

                         <!-- Akun MyUT -->
                        <h6 class="text-secondary fw-bold border-bottom pb-2 mb-3">Akun MyUT</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Password MyUT</label>
                                <div class="input-group">
                                    <input type="password" name="password_myut" id="myut_pass" class="form-control" value="{{ old('password_myut', $user->password_myut) }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('myut_pass')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">Biarkan kosong jika tidak ingin mengubah.</div>
                            </div>
                        </div>
                        <!-- Kontak -->
                        <h6 class="text-secondary fw-bold border-bottom pb-2 mb-3">Kontak</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $user->registration->whatsapp ?? '') }}" placeholder="Contoh: 08123456789">
                                </div>
                                <div class="form-text">Pastikan nomor aktif dan terhubung dengan WhatsApp.</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                             <a href="{{ route('admin.students.index') }}" class="btn btn-light border">Batal</a>
                             <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan ini?');">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                             </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Audit Log Preview (Optional: Show recent changes) -->
             @if($user->auditLogs && $user->auditLogs->count() > 0)
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0 text-muted"><i class="bi bi-clock-history me-2"></i>Riwayat Perubahan Data (Audit Log)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0" style="font-size: 0.9rem;">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Admin</th>
                                    <th>Aksi / Perubahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->auditLogs()->latest()->take(5)->get() as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                    <td>{{ $log->user->name ?? 'Unknown' }}</td>
                                    <td>
                                        <strong>{{ $log->action }}</strong>
                                        <div class="text-muted small">{{ $log->description }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
    const initialProgram = "{{ $user->registration->fokus_karir ?? '' }}";
    
    function togglePassword(id) {
        var input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }

    function confirmProgramChange(select) {
        var warningDiv = document.getElementById('programWarning');
        if (select.value !== initialProgram) {
            warningDiv.style.display = 'block';
            if(!confirm("Peringatan: Mengubah Program Unggulan dapat mempengaruhi struktur kurikulum dan biaya mahasiswa. Apakah Anda yakin?")) {
                select.value = initialProgram;
                warningDiv.style.display = 'none';
            }
        } else {
            warningDiv.style.display = 'none';
        }
    }
</script>
@endsection
