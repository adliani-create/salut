@extends('layouts.admin')

@section('title', 'Jadwal Akademik')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Jadwal Akademik (Tugas/Diskusi/Tuweb/Ujian)</h2>
        <a href="{{ route('admin.academic-schedules.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Jadwal
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tipe</th>
                            <th>Mata Kuliah / Judul</th>
                            <th>Waktu Pelaksanaan</th>
                            <th>Batas Akhir (Deadline)</th>
                            <th>Target Info</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                        <tr>
                            <td>
                                @php
                                    $bg = 'secondary';
                                    if($schedule->type == 'tugas') $bg = 'primary';
                                    if($schedule->type == 'diskusi') $bg = 'info text-dark';
                                    if($schedule->type == 'tuweb') $bg = 'warning text-dark';
                                    if($schedule->type == 'ujian') $bg = 'danger';
                                @endphp
                                <span class="badge bg-{{ $bg }} text-uppercase">{{ $schedule->type }}</span>
                            </td>
                            <td class="fw-bold">{{ $schedule->title }}</td>
                            <td>
                                {{ $schedule->date->format('d M Y') }}<br>
                                <span class="text-muted small"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB</span>
                            </td>
                            <td>
                                @if($schedule->deadline)
                                    <span class="text-danger"><i class="bi bi-calendar-x me-1"></i>{{ $schedule->deadline->format('d M Y, H:i') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    @if($schedule->user_id)
                                        <span class="badge bg-warning text-dark"><i class="bi bi-person-fill me-1"></i>Spesifik: {{ $schedule->user->name ?? 'Mahasiswa' }}</span>
                                    @else
                                        <strong>Semester:</strong> {!! $schedule->target_semester ? '<span class="badge bg-primary">'.$schedule->target_semester.'</span>' : '<span class="text-muted">Semua Semester</span>' !!}<br>
                                        <strong>Prodi:</strong> {!! $schedule->prodi_id ? '<span class="badge bg-success">'.$schedule->prodi->nama.'</span>' : '<span class="text-muted">Semua Prodi</span>' !!}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.academic-schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning mb-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.academic-schedules.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger mb-1"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data jadwal akademik yang dibuat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
