@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-info text-white text-center py-4">
                    <h3 class="font-weight-light my-2">Fokus Karir Masa Depan</h3>
                    <p class="mb-0 text-white-50">Langkah 3/3: Pilih salah satu fokus karirmu</p>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register.step3.store') }}">
                        @csrf

                        <div class="row g-4">
                            <!-- Helper for selection -->
                            <input type="hidden" name="fokus_karir" id="fokus_karir" required>

                            <!-- Option 1 -->
                            <div class="col-md-6">
                                <div class="card h-100 career-card" onclick="selectCareer(this, 'Kuliah Plus Magang Kerja')">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3 text-primary"><i class="bi bi-briefcase fs-1"></i></div>
                                        <h5 class="card-title fw-bold">Kuliah Plus Magang Kerja</h5>
                                        <p class="card-text text-muted small">Cocok untuk kamu yang ingin lulus langsung siap kerja. Mendapatkan penempatan magang di perusahaan mitra sejak semester awal.</p>
                                        <div class="check-icon mt-3 d-none"><i class="bi bi-check-circle-fill text-success fs-3"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Option 2 -->
                            <div class="col-md-6">
                                <div class="card h-100 career-card" onclick="selectCareer(this, 'Kuliah Plus Skill Academy')">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3 text-danger"><i class="bi bi-laptop fs-1"></i></div>
                                        <h5 class="card-title fw-bold">Kuliah Plus Skill Academy</h5>
                                        <p class="card-text text-muted small">Fokus pada sertifikasi dan keahlian teknis spesifik. Akses bootcamp dan pelatihan intensif (Coding, Desain, Bahasa).</p>
                                        <div class="check-icon mt-3 d-none"><i class="bi bi-check-circle-fill text-success fs-3"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Option 3 -->
                            <div class="col-md-6">
                                <div class="card h-100 career-card" onclick="selectCareer(this, 'Kuliah Plus Affiliator/Creator')">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3 text-warning"><i class="bi bi-share fs-1"></i></div>
                                        <h5 class="card-title fw-bold">Kuliah Plus Affiliator/Creator</h5>
                                        <p class="card-text text-muted small">Untuk kamu yang ingin sukses di dunia digital & medsos. Pelatihan menjadi Content Creator, Digital Marketer dengan monetisasi.</p>
                                        <div class="check-icon mt-3 d-none"><i class="bi bi-check-circle-fill text-success fs-3"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Option 4 -->
                            <div class="col-md-6">
                                <div class="card h-100 career-card" onclick="selectCareer(this, 'Kuliah Plus Wirausaha')">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3 text-success"><i class="bi bi-shop fs-1"></i></div>
                                        <h5 class="card-title fw-bold">Kuliah Plus Wirausaha</h5>
                                        <p class="card-text text-muted small">Bangun bisnis sendiri sejak mahasiswa. Inkubasi bisnis, mentoring dengan pengusaha sukses, dan akses ke jaringan pendanaan.</p>
                                        <div class="check-icon mt-3 d-none"><i class="bi bi-check-circle-fill text-success fs-3"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('fokus_karir')
                            <div class="text-center text-danger mt-4 fw-bold">{{ $message }}</div>
                        @enderror

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                {{ __('Selesai & Daftar') }} <i class="bi bi-check-lg ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .career-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .career-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .career-card.selected {
        border-color: #198754; /* Success color */
        background-color: #f8f9fa;
    }
    .career-card.selected .check-icon {
        display: block !important;
    }
</style>

<script>
    function selectCareer(card, value) {
        // Remove selected class from all cards
        document.querySelectorAll('.career-card').forEach(el => {
            el.classList.remove('selected');
            el.querySelector('.check-icon').classList.add('d-none');
        });

        // Add selected class to clicked card
        card.classList.add('selected');
        card.querySelector('.check-icon').classList.remove('d-none');

        // Set hidden input value
        document.getElementById('fokus_karir').value = value;

        // Enable submit button
        document.getElementById('submitBtn').disabled = false;
    }
</script>
@endsection
