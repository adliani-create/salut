@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Edit Beranda (Landing Page)</h5>
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.home-settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="hero_title" class="form-label fw-semibold">Judul Utama (Hero Title)</label>
                        <input type="text" class="form-control" id="hero_title" name="hero_title" value="{{ old('hero_title', $setting->hero_title) }}" required>
                        <div class="form-text">Teks besar yang muncul pertama kali di halapan depan.</div>
                    </div>

                    <div class="mb-4">
                        <label for="hero_subtitle" class="form-label fw-semibold">Sub-Judul</label>
                        <input type="text" class="form-control" id="hero_subtitle" name="hero_subtitle" value="{{ old('hero_subtitle', $setting->hero_subtitle) }}">
                    </div>

                    <div class="mb-4">
                        <label for="banner_image" class="form-label fw-semibold">Gambar Banner Utama</label>
                        
                        @if($setting->banner_path)
                            <div class="mb-3">
                                <img src="{{ Storage::url($setting->banner_path) }}" alt="Current Banner" class="img-fluid rounded shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
                            </div>
                        @else
                            <div class="alert alert-secondary mb-3">
                                <small>Saat ini menggunakan gambar default sistem.</small>
                            </div>
                        @endif

                        <input type="file" class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" name="banner_image" accept="image/*">
                        <div class="form-text">Format: JPG, PNG. Rekomendasi ukuran: 1920x800 px. Max: 10MB.</div>
                        @error('banner_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-5">

                    <h5 class="fw-bold mb-4 text-primary">Edit "Tentang Kami"</h5>
                    
                    <div class="mb-4">
                        <label for="about_title" class="form-label fw-semibold">Judul Tentang Kami</label>
                        <input type="text" class="form-control" id="about_title" name="about_title" value="{{ old('about_title', $setting->about_title ?? 'SALUT Indo Global') }}">
                    </div>

                    <div class="mb-4">
                        <label for="about_content" class="form-label fw-semibold">Konten / Deskripsi</label>
                        <textarea class="form-control" id="about_content" name="about_content" rows="6">{{ old('about_content', $setting->about_content) }}</textarea>
                        <div class="form-text">Bisa menggunakan HTML dasar untuk paragraf dan list.</div>
                    </div>

                    <div class="mb-4">
                        <label for="about_image" class="form-label fw-semibold">Gambar Tentang Kami</label>
                        @if($setting->about_image)
                            <div class="mb-3">
                                <img src="{{ Storage::url($setting->about_image) }}" alt="About Img" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                            </div>
                        @endif
                        <input type="file" class="form-control" id="about_image" name="about_image" accept="image/*">
                    </div>

                    <hr class="my-5">

                    <hr class="my-5">

                    <!-- Footer Settings Card -->
                    <div class="card border-0 shadow-sm bg-white mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold text-primary">Pengaturan Footer</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label for="footer_description" class="form-label fw-semibold">Deskripsi Singkat Footer</label>
                                <textarea class="form-control" id="footer_description" name="footer_description" rows="3" placeholder="Contoh: Mitra resmi Universitas Terbuka...">{{ old('footer_description', $setting->footer_description) }}</textarea>
                                <div class="form-text">Teks yang muncul di bawah logo pada kolom pertama footer.</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label fw-semibold">Email Kontak</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $setting->email) }}" placeholder="contoh@email.com">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $setting->phone) }}" placeholder="08xxx / (021) xxx">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="address" class="form-label fw-semibold">Alamat Resmi</label>
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Jl. Contoh No. 123...">{{ old('address', $setting->address) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="google_maps_link" class="form-label fw-semibold"><i class="bi bi-geo-alt-fill me-1"></i> Link Google Maps</label>
                                <input type="url" class="form-control" id="google_maps_link" name="google_maps_link" value="{{ old('google_maps_link', $setting->google_maps_link) }}" placeholder="https://maps.app.goo.gl/...">
                                <div class="form-text">Link menuju lokasi kampus di Google Maps.</div>
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-3">Sosial Media</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="instagram_url" class="form-label fw-semibold"><i class="bi bi-instagram me-1"></i> Instagram URL</label>
                                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $setting->instagram_url) }}" placeholder="https://instagram.com/...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tiktok_url" class="form-label fw-semibold"><i class="bi bi-tiktok me-1"></i> TikTok URL</label>
                                    <input type="url" class="form-control" id="tiktok_url" name="tiktok_url" value="{{ old('tiktok_url', $setting->tiktok_url) }}" placeholder="https://tiktok.com/@...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-4 text-primary">Kontak WhatsApp (Floating Button)</h5>

                    <div class="mb-4">
                        <label for="whatsapp" class="form-label fw-semibold">Nomor WhatsApp Admin (Format: 628xxx)</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $setting->whatsapp) }}" placeholder="Contoh: 628123456789">
                        <div class="form-text">Nomor ini akan digunakan untuk tombol chat WhatsApp di pojok kanan bawah.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan Footer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Panduan</h6>
                <p class="small text-muted mb-0">
                    Halaman ini digunakan untuk mengubah tampilan utama website (Landing Page).
                    Perubahan yang Anda simpan akan <strong>langsung terlihat</strong> oleh pengunjung umum.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
