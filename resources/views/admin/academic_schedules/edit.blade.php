@extends('layouts.admin')

@section('title', 'Edit Jadwal Akademik')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Jadwal Akademik</h2>
        <a href="{{ route('admin.academic-schedules.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.academic-schedules.update', $academicSchedule->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kategori Jadwal <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="tugas" {{ old('type', $academicSchedule->type) == 'tugas' ? 'selected' : '' }}>Tugas</option>
                            <option value="diskusi" {{ old('type', $academicSchedule->type) == 'diskusi' ? 'selected' : '' }}>Diskusi</option>
                            <option value="tuweb" {{ old('type', $academicSchedule->type) == 'tuweb' ? 'selected' : '' }}>Tuweb (Tutorial Webinar)</option>
                            <option value="ujian" {{ old('type', $academicSchedule->type) == 'ujian' ? 'selected' : '' }}>Ujian</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Mata Kuliah / Judul Acara <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $academicSchedule->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $academicSchedule->date->format('Y-m-d')) }}" required>
                        @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jam Pelaksanaan (WIB) <span class="text-danger">*</span></label>
                        <input type="time" name="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time', \Carbon\Carbon::parse($academicSchedule->time)->format('H:i')) }}" required>
                        @error('time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Batas Waktu (Deadline)</label>
                        <input type="datetime-local" name="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline', $academicSchedule->deadline ? $academicSchedule->deadline->format('Y-m-d\TH:i') : '') }}">
                        <div class="form-text text-muted">Kosongkan jika materi ini tidak memiliki rentang batas waktu tenggat.</div>
                        @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mt-5">
                        <h5 class="fw-bold border-bottom pb-2">Target Filter Mahasiswa (Opsional)</h5>
                        <p class="text-muted small">Jika <strong>Mahasiswa Spesifik</strong> dipilih, filter Semester dan Program Studi akan diabaikan.</p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Tugaskan ke Mahasiswa Spesifik</label>
                        <select name="user_id" class="form-select select2-students @error('user_id') is-invalid @enderror">
                            <option value="">-- Semua Mahasiswa (Gunakan Filter Semester/Program di Bawah) --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('user_id', $academicSchedule->user_id) == $student->id ? 'selected' : '' }}>
                                    {{ $student->nim ?? 'No NIM' }} - {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Semester Target</label>
                        <select name="target_semester" class="form-select @error('target_semester') is-invalid @enderror">
                            <option value="">Semua Semester</option>
                            @for($i=1; $i<=8; $i++)
                                <option value="{{ $i }}" {{ old('target_semester', $academicSchedule->target_semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                            @endfor
                        </select>
                        @error('target_semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                    <label class="form-label">Program Studi Target</label>
                    <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror">
                        <option value="">Semua Program Studi</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('prodi_id', $academicSchedule->prodi_id) == $program->id ? 'selected' : '' }}>
                                {{ $program->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('prodi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                <div class="mt-5 text-end">
                    <button type="submit" class="btn btn-warning px-5 py-2 fw-bold text-dark">
                        <i class="bi bi-pencil-square me-1"></i> Perbarui Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-students').select2({
            theme: 'bootstrap-5',
            placeholder: "-- Semua Mahasiswa (Gunakan Filter Semester/Program di Bawah) --",
            allowClear: true,
            width: '100%'
        });

        // Initial Load State
        if ($('.select2-students').val()) {
            $('select[name="target_semester"]').prop('disabled', true);
            $('select[name="prodi_id"]').prop('disabled', true);
        } else if ($('select[name="target_semester"]').val() || $('select[name="prodi_id"]').val()) {
            $('.select2-students').prop('disabled', true);
        }

        // Event Listeners
        $('.select2-students, select[name="target_semester"], select[name="prodi_id"]').on('change', function() {
            if ($(this).hasClass('select2-students')) {
                if ($(this).val()) {
                    $('select[name="target_semester"]').prop('disabled', true).val('');
                    $('select[name="prodi_id"]').prop('disabled', true).val('');
                } else {
                    $('select[name="target_semester"]').prop('disabled', false);
                    $('select[name="prodi_id"]').prop('disabled', false);
                }
            } else {
                if ($('select[name="target_semester"]').val() || $('select[name="prodi_id"]').val()) {
                    $('.select2-students').prop('disabled', true).val('').trigger('change.select2');
                } else {
                    $('.select2-students').prop('disabled', false);
                }
            }
        });
    });
</script>
@endpush
