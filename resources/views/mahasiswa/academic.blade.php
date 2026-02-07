@extends('layouts.student')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark">Ringkasan Akademik</h3>
    <p class="text-muted">Pantau pencapaian akademik dan riwayat studi Anda.</p>
</div>

<!-- 1. Hero Summary Widget -->
<div class="row g-3 mb-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white position-relative overflow-hidden">
            <div class="card-body p-4 position-relative z-1">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                        <i class="bi bi-trophy-fill fs-4 text-white"></i>
                    </div>
                    <h6 class="mb-0 text-white text-opacity-75">IPK Kumulatif</h6>
                </div>
                <h2 class="display-4 fw-bold mb-0">{{ number_format($ipk, 2) }}</h2>
                <div class="mt-2 text-white text-opacity-75 small">Indeks Prestasi Kumulatif</div>
            </div>
            <!-- Decorative circle -->
            <div class="position-absolute top-0 end-0 bg-white opacity-10 rounded-circle" style="width: 150px; height: 150px; margin-right: -40px; margin-top: -40px;"></div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-book-half fs-4 text-success"></i>
                    </div>
                    <h6 class="mb-0 text-muted">Total SKS Lulus</h6>
                </div>
                <h2 class="display-4 fw-bold text-dark mb-0">{{ $totalSks }}</h2>
                <div class="mt-2 text-muted small">Satuan Kredit Semester</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-star-fill fs-4 text-warning"></i>
                    </div>
                    <h6 class="mb-0 text-muted">Predikat Saat Ini</h6>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $predicate }}</h3>
                <div class="mt-2 text-muted small">Berdasarkan data akademik terakhir</div>
            </div>
        </div>
    </div>
</div>

<!-- 2. Semester List (Accordion) -->
<h5 class="fw-bold text-dark mb-3">Riwayat Studi Per Semester</h5>
<div class="accordion custom-accordion" id="accordionTranscript">
    @forelse($academicRecords as $index => $record)
        <div class="accordion-item border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
            <h2 class="accordion-header" id="heading{{ $index }}">
                <button class="accordion-button collapsed bg-white p-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center w-100 me-3">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <div class="bg-light text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                {{ $loop->iteration }}
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">{{ $record->semester }}</h6>
                                <small class="text-muted">Periode Studi</small>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-4">
                            <div class="text-md-end">
                                <small class="text-muted d-block small">Total SKS</small>
                                <span class="fw-bold text-dark">{{ $record->sks }}</span>
                            </div>
                             <div class="text-md-end border-start ps-4">
                                <small class="text-muted d-block small">IPS</small>
                                <span class="fw-bold text-primary">{{ number_format($record->ips, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </button>
            </h2>
            <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionTranscript">
                <div class="accordion-body bg-light p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="ps-4 py-3 text-muted small">Kode Mata Kuliah</th>
                                    <th class="py-3 text-muted small">Nama Mata Kuliah</th>
                                    <th class="py-3 text-center text-muted small">SKS</th>
                                    <th class="py-3 text-center text-muted small">Nilai</th>
                                    <th class="pe-4 py-3 text-end text-muted small">Bobot</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($record->grades as $course)
                                    <tr class="bg-white border-bottom">
                                        <td class="ps-4 py-3 fw-bold text-dark">{{ $course->code }}</td>
                                        <td class="py-3">{{ $course->name }}</td>
                                        <td class="py-3 text-center">{{ $course->sks }}</td>
                                        <td class="py-3 text-center">
                                            @php
                                                $badgeClass = 'bg-secondary';
                                                $gradePrefix = substr($course->grade, 0, 1);
                                                
                                                if($gradePrefix == 'A') $badgeClass = 'bg-success';
                                                elseif($gradePrefix == 'B') $badgeClass = 'bg-primary';
                                                elseif($gradePrefix == 'C') $badgeClass = 'bg-warning text-dark';
                                                elseif($gradePrefix == 'D' || $gradePrefix == 'E') $badgeClass = 'bg-danger';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} rounded-pill px-3">{{ $course->grade }}</span>
                                        </td>
                                        <td class="pe-4 py-3 text-end fw-bold">{{ number_format($course->score, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-file-earmark-x fs-1 text-muted opacity-50"></i>
            <p class="text-muted mt-3">Belum ada data akademik tersedia.</p>
        </div>
    @endforelse
</div>

<style>
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa !important;
        box-shadow: none;
    }
    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230d6efd'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
</style>
@endsection
