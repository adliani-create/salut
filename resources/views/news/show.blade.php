@extends('layouts.app')

@section('content')
<!-- Detail Header -->
<header class="bg-primary text-white py-5 mb-5" style="background: linear-gradient(rgba(13, 110, 253, 0.9), rgba(13, 110, 253, 0.9)), url('{{ $news->thumbnail ? Storage::url($news->thumbnail) : '' }}') center/cover;">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold mb-3">{{ $news->title }}</h1>
        <p class="lead opacity-75 mb-0">
            <i class="bi bi-calendar-event me-2"></i>{{ $news->published_at->format('d F Y') }}
        </p>
    </div>
</header>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                @if($news->thumbnail)
                    <img src="{{ Storage::url($news->thumbnail) }}" class="card-img-top" alt="{{ $news->title }}" style="max-height: 400px; object-fit: cover;">
                @endif
                <div class="card-body p-4 p-lg-5">
                    <div class="news-content text-dark lh-lg">
                        {!! $news->content !!} 
                        <!-- Note: outputting unescaped HTML because admin is trusted author. In production, use HTMLPurifier if open to public input. -->
                    </div>
                </div>
                <div class="card-footer bg-white p-4 border-top-0 d-flex justify-content-between">
                    <a href="{{ route('landing') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
