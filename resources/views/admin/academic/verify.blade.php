@extends('layouts.admin')

@section('content')
<div class="container-fluid py-3 h-100">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold m-0"><i class="bi bi-patch-check me-2"></i>Verifikasi & Koreksi Nilai</h4>
        <div>
            <span class="badge bg-light text-dark border p-2 me-2">Mahasiswa: {{ $user->name }}</span>
            <button class="btn btn-sm btn-outline-secondary me-2" type="button" data-bs-toggle="collapse" data-bs-target="#debugText">
                <i class="bi bi-bug"></i> Debug Text
            </button>
            <span class="badge bg-primary p-2">Semester: {{ $semester }}</span>
        </div>
    </div>
    
    <div class="collapse mb-3" id="debugText">
        <div class="card card-body bg-dark text-light font-monospace small" style="max-height: 200px; overflow: auto;">
            <pre>{{ $raw_text }}</pre>
        </div>
    </div>

    <form action="{{ route('admin.academic.store', $user->id) }}" method="POST">
        @csrf
        <input type="hidden" name="semester" value="{{ $semester }}">
        <input type="hidden" name="pdf_path" value="{{ $pdf_path }}">

        <div class="row g-3" style="min-height: 80vh;">
            <!-- Left: PDF Preview -->
            <div class="col-md-6 h-100">
                <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                    <iframe src="{{ $pdf_url }}" style="width: 100%; height: 800px; border: none;"></iframe>
                </div>
            </div>

            <!-- Right: Form Extraction -->
            <div class="col-md-6 h-100">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between">
                        <h6 class="fw-bold m-0 text-primary">Draft Hasil Ekstraksi</h6>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="addRow()"><i class="bi bi-plus-lg"></i> Tambah Baris</button>
                    </div>
                    <div class="card-body p-0 overflow-auto" style="max-height: 700px;">
                        <table class="table table-bordered mb-0" id="gradeTable">
                            <thead class="bg-light sticky-top">
                                <tr>
                                    <th style="width: 15%">Kode</th>
                                    <th>Mata Kuliah</th>
                                    <th style="width: 10%">SKS</th>
                                    <th style="width: 15%">Nilai</th>
                                    <th style="width: 5%"></th>
                                </tr>
                            </thead>
                            <tbody id="gradeBody">
                                @foreach($courses as $index => $c)
                                <tr>
                                    <td><input type="text" name="courses[{{$index}}][code]" class="form-control form-control-sm" value="{{ $c['code'] }}"></td>
                                    <td><input type="text" name="courses[{{$index}}][name]" class="form-control form-control-sm" value="{{ $c['name'] }}" required></td>
                                    <td><input type="number" name="courses[{{$index}}][sks]" class="form-control form-control-sm sks-input" value="{{ $c['sks'] }}" required></td>
                                    <td>
                                        <select name="courses[{{$index}}][grade]" class="form-select form-select-sm" required>
                                            @foreach(['A','A-','B+','B','B-','C+','C','C-','D','E'] as $g)
                                                <option value="{{ $g }}" {{ $c['grade'] == $g ? 'selected' : '' }}>{{ $g }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-sm btn-light text-danger" onclick="this.closest('tr').remove()"><i class="bi bi-trash"></i></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if(empty($courses))
                        <div class="p-4 text-center text-muted" id="emptyState">
                            <i class="bi bi-info-circle mb-2 d-block fs-4"></i>
                            Tidak ada data terbaca. Silakan tambah baris manual.
                        </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-top p-3 text-end sticky-bottom">
                         <a href="{{ route('admin.academic.upload', $user->id) }}" class="btn btn-light me-2">Batal</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="bi bi-save me-2"></i> Simpan & Publish
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let rowIndex = {{ count($courses) }};
    
    function addRow() {
        document.getElementById('emptyState')?.remove();
        
        let html = `
            <tr>
                <td><input type="text" name="courses[${rowIndex}][code]" class="form-control form-control-sm"></td>
                <td><input type="text" name="courses[${rowIndex}][name]" class="form-control form-control-sm" required></td>
                <td><input type="number" name="courses[${rowIndex}][sks]" class="form-control form-control-sm sks-input" value="3" required></td>
                <td>
                    <select name="courses[${rowIndex}][grade]" class="form-select form-select-sm" required>
                        <option value="A">A</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B">B</option>
                        <option value="B-">B-</option>
                        <option value="C+">C+</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </td>
                <td><button type="button" class="btn btn-sm btn-light text-danger" onclick="this.closest('tr').remove()"><i class="bi bi-trash"></i></button></td>
            </tr>
        `;
        document.getElementById('gradeBody').insertAdjacentHTML('beforeend', html);
        rowIndex++;
    }
</script>
@endpush
@endsection
