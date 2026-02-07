@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-success text-white text-center py-4">
                    <h3 class="font-weight-light my-2">Lengkapi Data Akademik</h3>
                    <p class="mb-0 text-white-50">Langkah 2/2: Data Diri & Peminatan</p>
                </div>
                <div class="card-body p-5">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.step2.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="whatsapp" class="form-label fw-bold">{{ __('No. WhatsApp') }}</label>
                            <input id="whatsapp" type="number" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="08xxxxxxxxxx">
                            <div class="form-text">Nomor aktif untuk notifikasi penting.</div>
                            @error('whatsapp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Jenjang Pendidikan') }}</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenjang" id="jenjangS1" value="S1" checked>
                                    <label class="form-check-label" for="jenjangS1">S1 (Sarjana)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenjang" id="jenjangS2" value="S2">
                                    <label class="form-check-label" for="jenjangS2">S2 (Magister)</label>
                                </div>
                            </div>
                            @error('jenjang')
                                <span class="text-danger small"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fakultas" class="form-label fw-bold">{{ __('Fakultas') }}</label>
                                <select id="fakultasSelect" class="form-select @error('fakultas') is-invalid @enderror" name="fakultas_id" required onchange="loadProdis(this.value)">
                                    <option value="" selected disabled>Pilih Fakultas...</option>
                                    @foreach($fakultas as $f)
                                        <option value="{{ $f->id }}">{{ $f->nama }} - {{ $f->kode }}</option>
                                    @endforeach
                                </select>
                                <!-- Hidden input to store Name if needed or handle in controller -->
                                @error('fakultas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="prodi" class="form-label fw-bold">{{ __('Jurusan / Prodi') }}</label>
                                <select id="prodiSelect" class="form-select @error('prodi') is-invalid @enderror" name="prodi_id" required disabled>
                                    <option value="" selected disabled>Pilih Fakultas Terlebih Dahulu...</option>
                                    <!-- Options loaded via AJAX -->
                                </select>
                                @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <script>
                            function loadProdis(fakultasId) {
                                if (!fakultasId) return;
                                
                                const prodiSelect = document.getElementById('prodiSelect');
                                prodiSelect.disabled = true;
                                prodiSelect.innerHTML = '<option value="" selected>Loading...</option>';

                                fetch(`{{ url('ajax/fakultas') }}/${fakultasId}/prodis`)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        prodiSelect.innerHTML = '<option value="" selected disabled>Pilih Prodi...</option>';
                                        data.forEach(prodi => {
                                            // Using ID as value for submitting, we will handle ID->Name in controller if needed
                                            // Or use Nama as value if we want to stick to string storage directly.
                                            // Let's use ID to be robust with the prompt "Relasi One-to-Many" (IDs usually).
                                            const option = document.createElement('option');
                                            option.value = prodi.id; 
                                            option.text = prodi.nama + ' (' + prodi.jenjang + ')';
                                            prodiSelect.appendChild(option);
                                        });
                                        prodiSelect.disabled = false;
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        prodiSelect.innerHTML = '<option value="" selected disabled>Gagal memuat prodi</option>';
                                    });
                            }
                        </script>

                        <div class="mb-4">
                            <label for="jalur_pendaftaran" class="form-label fw-bold">{{ __('Jalur Pendaftaran') }}</label>
                            <select id="jalur_pendaftaran" class="form-select @error('jalur_pendaftaran') is-invalid @enderror" name="jalur_pendaftaran" required>
                                <option value="Reguler">Reguler (Non-RPL)</option>
                                <option value="RPL">RPL (Rekognisi Pembelajaran Lampau)</option>
                            </select>
                            @error('jalur_pendaftaran')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ __('Simpan & Daftar Sekarang') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
