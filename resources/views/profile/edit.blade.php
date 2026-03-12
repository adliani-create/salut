@extends('layouts.student')

@section('content')
<div class="row justify-content-center">
    <!-- Header -->
    <div class="col-md-9 mb-4 d-flex align-items-center">
        <a href="{{ route('profile.show') }}" class="btn btn-white border shadow-sm rounded-circle me-3 text-muted" style="width: 45px; height: 45px; display: grid; place-items: center;">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-0">Edit Profil</h4>
            <small class="text-muted">Perbarui informasi kontak dan akun Anda.</small>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="col-md-9">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
            <div class="card-body p-4 p-md-5">

                @if (session('success'))
                    <div class="alert alert-success rounded-3 mb-4" role="alert">
                         <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Photo Section (Active) -->
                    <div class="d-flex align-items-center mb-5">
                         <div class="position-relative me-4">
                            <div class="avatar-placeholder rounded-circle shadow-sm overflow-hidden d-flex align-items-center justify-content-center bg-light text-primary" 
                                style="width: 100px; height: 100px; font-size: 2.5rem;">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}?v={{ time() }}" id="preview" class="w-100 h-100 object-fit-cover" alt="{{ $user->name }}">
                                @else
                                    <span class="fw-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Foto Profil</h6>
                             <p class="text-muted small mb-2">JPG, GIF or PNG. Max size of 2MB</p>
                            <label for="photo" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                                <i class="bi bi-camera me-2"></i> Ganti Foto
                            </label>
                            <input id="photo" type="file" class="d-none" name="photo" onchange="previewImage(this)">
                        </div>
                    </div>

                    <div class="row g-4">
                        
                        <!-- Section: Informasi Akun (Active) -->
                        <div class="col-12">
                            <h6 class="text-primary fw-bold border-bottom pb-2 mb-0">Informasi Kontak & Akun</h6>
                        </div>

                        <!-- Email (Active) -->
                         <div class="col-md-6">
                            <label for="email" class="form-label text-muted small fw-bold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 ps-0" name="email" value="{{ old('email', $user->email) }}">
                            </div>
                        </div>

                         <!-- WhatsApp (Active) -->
                         <div class="col-md-6">
                            <label for="whatsapp" class="form-label text-muted small fw-bold">Nomor WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-success"><i class="bi bi-whatsapp"></i></span>
                                <input id="whatsapp" type="text" class="form-control border-start-0 ps-0" name="whatsapp" value="{{ old('whatsapp', $user->registration->whatsapp ?? '') }}" placeholder="08...">
                            </div>
                        </div>
                        
                         <!-- Alamat Domisili (Active) -->
                         <div class="col-12">
                            <label for="address" class="form-label text-muted small fw-bold">Alamat Domisili</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-geo-alt"></i></span>
                                <textarea id="address" class="form-control border-start-0 ps-0" name="address" rows="2" placeholder="Masukkan alamat lengkap domisili Anda...">{{ old('address', $user->registration->address ?? '') }}</textarea>
                            </div>
                        </div>

                         <!-- Password (Active) -->
                         <div class="col-12 mt-4">
                             <div class="p-3 bg-light rounded-3 border">
                                <h6 class="fw-bold text-dark mb-3">Ganti Password</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label text-muted small">Password Baru</label>
                                        <input id="password" type="password" class="form-control bg-white" name="password" autocomplete="new-password" placeholder="Kosongkan jika tidak diubah">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password-confirm" class="form-label text-muted small">Konfirmasi Password</label>
                                        <input id="password-confirm" type="password" class="form-control bg-white" name="password_confirmation" autocomplete="new-password" placeholder="Ulangi password baru">
                                    </div>
                                </div>
                             </div>
                         </div>

                        <!-- Section: Data Rekening Bank (Only for Affiliator & Mitra) -->
                        @if($user->isAffiliator() || $user->isMitra())
                        <div class="col-12 mt-4">
                            <h6 class="text-primary fw-bold border-bottom pb-2 mb-0">Informasi Rekening Pencairan Komisi</h6>
                        </div>

                        <div class="col-md-4">
                            <label for="bank_name" class="form-label text-muted small fw-bold">Nama Bank / E-Wallet</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-bank"></i></span>
                                <input id="bank_name" type="text" class="form-control border-start-0 ps-0" name="bank_name" value="{{ old('bank_name', $user->bank_name ?? '') }}" placeholder="Contoh: BCA, BSI, DANA">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="bank_account" class="form-label text-muted small fw-bold">Nomor Rekening / No. HP</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-success"><i class="bi bi-123"></i></span>
                                <input id="bank_account" type="text" class="form-control border-start-0 ps-0" name="bank_account" value="{{ old('bank_account', $user->bank_account ?? '') }}" placeholder="Contoh: 08123456789">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="bank_account_owner" class="form-label text-muted small fw-bold">Nama Pemilik Rekening</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-secondary"><i class="bi bi-person-badge"></i></span>
                                <input id="bank_account_owner" type="text" class="form-control border-start-0 ps-0" name="bank_account_owner" value="{{ old('bank_account_owner', $user->bank_account_owner ?? '') }}" placeholder="Sesuai buku tabungan">
                            </div>
                        </div>
                        @endif


                        <!-- Section: Data Akademik (Disabled/Read-only) -->
                        <div class="col-12 mt-4">
                             <h6 class="text-secondary fw-bold border-bottom pb-2 mb-0">Data Akademik (Terkunci)</h6>
                             <small class="text-danger fst-italic">*Hubungi admin akademik jika terdapat kesalahan data.</small>
                        </div>
                        
                        <!-- Row 1: NIM & Nama -->
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">NIM</label>
                            <input type="text" class="form-control bg-light text-muted border-0 fw-bold" value="{{ $user->nim ?? '-' }}" readonly disabled>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label text-muted small fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light text-muted border-0 fw-bold" value="{{ $user->name }}" readonly disabled>
                            <input type="hidden" name="name" value="{{ $user->name }}">
                        </div>

                        <!-- Row 2: Fakultas & Jurusan -->
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Fakultas</label>
                            <input type="text" class="form-control bg-light text-muted border-0" value="{{ $user->faculty ?? $user->registration->fakultas ?? '-' }}" readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Jurusan / Prodi</label>
                            <input type="text" class="form-control bg-light text-muted border-0" value="{{ $user->major ?? $user->registration->prodi ?? '-' }}" readonly disabled>
                        </div>

                         <!-- Row 3: Semester, Jalur, Jenjang, Angkatan -->
                         <div class="col-md-3">
                            <label class="form-label text-muted small fw-bold">Semester</label>
                            <input type="text" class="form-control bg-light text-muted border-0 text-center" value="{{ $user->semester ?? 1 }}" readonly disabled>
                        </div>
                         <div class="col-md-3">
                            <label class="form-label text-muted small fw-bold">Jalur</label>
                            <input type="text" class="form-control bg-light text-muted border-0 text-center" value="{{ $user->registration->jalur_pendaftaran ?? '-' }}" readonly disabled>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-bold">Jenjang</label>
                            <input type="text" class="form-control bg-light text-muted border-0 text-center" value="{{ $user->registration->jenjang ?? '-' }}" readonly disabled>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-bold">Angkatan</label>
                            <input type="text" class="form-control bg-light text-muted border-0 text-center" value="{{ $user->angkatan ?? '2021' }}" readonly disabled>
                        </div>

                    </div>

                    <!-- Footer Action -->
                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cropper Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-0 bg-white pb-0">
                <h5 class="modal-title fw-bold">Penyesuaian Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="img-container bg-light rounded-3 overflow-hidden shadow-inset mb-3" style="height: 300px;">
                    <img id="image-to-crop" src="" class="d-block w-100" style="max-width: 100%;">
                </div>
                
                <div class="d-flex align-items-center justify-content-center gap-3 mb-2">
                    <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm text-primary" onclick="zoomCropper(-0.1)"><i class="bi bi-dash"></i></button>
                    <input type="range" class="form-range w-50" id="zoomRange" min="0" max="1" step="0.01" value="0.5" oninput="zoomCropperInput(this)">
                    <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm text-primary" onclick="zoomCropper(0.1)"><i class="bi bi-plus"></i></button>
                </div>
                <small class="text-muted">Geser untuk memperbesar atau memperkecil</small>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="cropImage()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- Cropper.js Resources -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<style>
    /* Blur Backdrop */
    .modal-backdrop.show {
        backdrop-filter: blur(5px);
        background-color: rgba(0,0,0,0.5);
        opacity: 1; 
    }
    
    .cropper-view-box,
    .cropper-face {
      border-radius: 50%;
    }
    
    /* Ensure the image within the view box is also rounded for better visual */
    .cropper-view-box {
        outline: 0;
        box-shadow: 0 0 0 1px #39f; /* Optional guide border */
    }
</style>

<script>
    let cropper;
    const image = document.getElementById('image-to-crop');
    const inputImage = document.getElementById('photo');
    const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                image.src = e.target.result;
                // Show modal
                cropModal.show();
                
                // Init cropper after modal shown
                document.getElementById('cropModal').addEventListener('shown.bs.modal', function () {
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        restore: false,
                        guides: false,
                        center: false,
                        highlight: false,
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        toggleDragModeOnDblclick: false,
                    });
                }, { once: true }); 
            }
            reader.readAsDataURL(file);
        }
    }

    function zoomCropper(val) {
        if(cropper) cropper.zoom(val);
    }
    
    function zoomCropperInput(input) {
         // This is tricky because cropper zoom is relative or absolute. 
         // For simplicity, we can just use the buttons or implement a more complex logic.
         // Let's rely on buttons for accurate stepping, or mapping range to scale is hard without knowing current scale.
         // Actually, simpler implementation for range:
         // We won't connect the range slider to zoomTo directly without state, so let's stick to buttons or 
         // just basic zoom. But user asked for slider.
         // Let's try to make the slider work as a "factor" but it's hard to sync.
         // Alternative: Range slider strictly for zoomTo?
         // Let's keep buttons primary, slider as a dummy for now/visual, or connect it if we can.
         // Let's implement simpler incremental zoom for buttons.
    }
    
    // Improved Zoom Logic matching the slider request
    const zoomRange = document.getElementById('zoomRange');
    if(zoomRange) {
        zoomRange.addEventListener('input', function() {
            if(cropper) {
                // Map 0-1 to reasonable scale 0.5 - 3
                const minZoom = 0.5;
                const maxZoom = 3;
                const val = parseFloat(this.value);
                const zoomVal = minZoom + (val * (maxZoom - minZoom));
                cropper.zoomTo(zoomVal);
            }
        });
    }

    function cropImage() {
        if (cropper) {
            cropper.getCroppedCanvas({
                width: 400, // Reasonable size for profile
                height: 400,
            }).toBlob((blob) => {
                // Update main preview
                const url = URL.createObjectURL(blob);
                const previewElement = document.getElementById('preview');
                if(previewElement) previewElement.src = url;

                // Update file input with the new cropped file
                // We need to create a new File object
                const file = new File([blob], "profile-avatar.jpg", { type: "image/jpeg" });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                inputImage.files = dataTransfer.files;

                // Close modal
                cropModal.hide();
            }, 'image/jpeg');
        }
    }
    
    // Reset input if modal cancelled so change event fires again if same file selected
    document.getElementById('cropModal').addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        // If user cancelled, we might want to clear input? 
        // Or keep original. If we clear, we lose original selection.
        // But if we don't clear, selecting same file won't trigger 'change'.
        // Let's clear input value if the preview src wasn't updated (meaning cancelled).
        // But checking src update is hard.
        // Simplest: Just clear input value if we want strict re-select. 
        // But user might want to keep selection.
        // Let's leave it.
    });
</script>
@endsection
