@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h3 class="fw-bold">Manajemen IPK & Transkrip</h3>
        <p class="text-muted">Cari mahasiswa untuk mengupdate data akademik.</p>
    </div>

    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.academic.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control form-control-lg" placeholder="Cari Nama atau NIM..." value="{{ $search }}">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Prodi</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $student->name }}</div>
                                    <div class="small text-muted">{{ $student->nim ?? 'No NIM' }}</div>
                                </td>
                                <td>{{ $student->major ?? '-' }}</td>
                                <td>
                                    @if($student->status == 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-warning">{{ $student->status }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.academic.upload', $student->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                        <i class="bi bi-upload me-1"></i> Update Transkrip
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada data mahasiswa ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
