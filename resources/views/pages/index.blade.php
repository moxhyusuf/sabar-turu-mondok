@extends('layouts_user.app')


@section('title', 'Sabar-Turu-Mondok')

@section('content')
<section id="travel-hero" class="travel-hero section dark-background">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 mt-5 mt-lg-0">
                <div class="content text-center">
                    <h1 class="fw-bold">SABAR TURU MONDOK</h1>
                    <p class="lead mt-2">
                        <span><strong>SA</strong>tu <strong>BAR</strong>code un<strong>TU</strong>k <strong>RU</strong>mah <strong>peMONDOK</strong>an</span>
                    </p>
                    <p>Mampu memberikan pelayanan kepada masyarakat untuk selalu tertib administrasi </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <a href="{{ url('/register') }}" class="btn btn-primary" target="_blank">Daftar Sekarang</a>
                        <a href="{{ url('/tours') }}" class="btn btn-outline-light">View</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<section id="why-us" class="why-us section">
            <div class="container">
                <div class="content-grid">
                    <div class="row g-4 align-items-stretch">

                        <!-- About Content -->
                        <div class="col-lg-6">
                            <div class="about-block">
                                <div class="about-header">
                                    <span class="section-badge">Tentang Kami</span>
                                    <h3>Tentang Sabar Turu Mondok</h3>
                                </div>

                                <div class="about-content">
                                    @if(isset($about))
                                    <p style="text-align: justify;">
                                        {{ $about->tentang_kami }}
                                    </p>
                                    @else
                                    <p>Belum ada data tentang kami yang ditambahkan.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="col-lg-6">
                            <div class="image-showcase">
                                <div class="main-image">

                                    @if(isset($about) && $about->img)
                                    <img src="{{ asset('storage/' . $about->img) }}"
                                        alt="Tentang Kami"
                                        class="img-fluid rounded-3">
                                    @else
                                    <img src="/assets/img/STM.jpg"
                                        alt="Default Image"
                                        class="img-fluid rounded-3">
                                    @endif

                                    <div class="overlay-badge">
                                        <div class="badge-content">
                                            <i class="bi bi-award-fill"></i>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Destinations Section -->
        <section id="featured-destinations" class="featured-destinations section mt-0">

            <div class="container">
                {{-- Header Section with Title and 'Lihat Selengkapnya' --}}
                <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
                    <div class="section-title text-start m-0 p-0">
                        <h2 class="mb-0" style="font-size: 2rem;">Rumah Pemondokan</h2>
                        <p class="mb-0 text-muted">Kecamatan Kanigaran Kota Probolinggo</p>
                    </div>
                    <div>
                        <a href="{{ route('user.kost') }}" class="btn-view-all">
                            Lihat Selengkapnya <i class="bi bi-arrow-right-short ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="news-list-container ListingContainer">
                    @forelse ($items ?? [] as $item)
                    <div class="news-list-wrapper mb-3" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="news-list-card d-flex align-items-center overflow-hidden rounded-3 bg-white shadow-sm border-0">
                            
                            {{-- Fixed Small Thumbnail using Background Image --}}
                            <div class="news-list-thumbnail" 
                                 style="background-image: url('{{ $item->images->count() ? asset('storage/'.$item->images->first()->image_path) : asset('assets/img/no-image.png') }}');">
                            </div>

                            {{-- Content Section - Compact News Style --}}
                            <div class="news-list-content p-3 d-flex flex-column justify-content-center flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="badge bg-primary-subtle text-primary border-0 rounded-pill px-2 py-1" style="font-size: 0.65rem; font-weight: 600;">
                                                {{ ucfirst($item->jenis_kost) }}
                                            </span>
                                            <span class="text-muted" style="font-size: 0.75rem;">
                                                <i class="bi bi-geo-alt me-1"></i> {{ $item->kelurahan }}
                                            </span>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1 list-title">{{ $item->nama_kost }}</h6>
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="owner-avatar-small me-2" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($item->user->nama ?? 'Owner') }}&background=random');"></div>
                                            <span class="text-muted small">Oleh: <span class="fw-semibold text-dark">{{ $item->user->nama ?? 'Admin' }}</span></span>
                                        </div>
                                        <p class="text-muted mt-2 mb-0 list-excerpt small">{{ Str::limit($item->alamat, 85) }}</p>
                                    </div>
                                    <div class="price-box text-end ps-3">
                                        <div class="fw-bold text-dark" style="font-size: 1rem;">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">/ bulan</small>
                                        <a href="{{ route('kost.detail', $item->id) }}" class="btn-detail-small mt-1 d-inline-block">
                                            Detail <i class="bi bi-chevron-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('assets/img/not-found.svg') }}" alt="Not Found" style="width: 120px; opacity: 0.5;">
                        <p class="mt-3 text-muted">Belum ada data kost terdaftar</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Alur Pendaftaran Section -->
        <section id="alur-pendaftaran" class="alur-pendaftaran section bg-light">
            <div class="container section-title">
                <h2>Alur Pendaftaran</h2>
                <div><span>Langkah mudah</span>
                    <span class="description-title">Mendaftarkan Rumah Pemondokan Anda</span>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="image-box text-center shadow-sm p-3 bg-white rounded-4 overflow-hidden">
                            @if(isset($alur) && $alur->count() > 0)
                                @foreach($alur as $item)
                                    <a href="{{ asset('storage/' . $item->img) }}" class="glightbox" data-gallery="alur-gallery">
                                        <img src="{{ asset('storage/' . $item->img) }}" 
                                             alt="Alur Pendaftaran" 
                                             class="img-fluid rounded-3 hover-zoom">
                                    </a>
                                @endforeach
                            @else
                                <a href="{{ asset('assets/img/prototype.jpg') }}" class="glightbox">
                                    <img src="{{ asset('assets/img/prototype.jpg') }}" 
                                         alt="Alur Pendaftaran Default" 
                                         class="img-fluid rounded-3 hover-zoom">
                                </a>
                            @endif
                            <div class="mt-3 text-muted small">
                                <i class="bi bi-zoom-in me-1"></i> Klik gambar untuk memperbesar
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('styles')
<style>
    .hero-text {
        position: relative;
        display: inline-block;
        padding: 0 20px;
        border-left: 3px solid #e50914;
        border-right: 3px solid #e50914;
    }

    .hero-text h1 {
        font-size: 3rem;
        font-weight: 800;
        color: #fff;
        margin: 0;
        letter-spacing: 1px;
    }

    .hero-text .tagline {
        margin-top: 8px;
        color: #fff;
        font-size: 1.2rem;
    }

    /* Compact News List Style */
    .btn-view-all {
        font-size: 0.9rem;
        color: var(--accent-color, #007bff);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        background: #f0f7ff;
        padding: 5px 15px;
        border-radius: 50px;
    }
    
    .btn-view-all:hover {
        background: var(--accent-color, #007bff);
        color: white;
    }

    .news-list-card {
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0 !important;
    }

    .news-list-card:hover {
        border-color: var(--accent-color, #007bff) !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05) !important;
    }

    .news-list-thumbnail {
        width: 100px !important;
        min-width: 100px !important;
        height: 100px !important;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 8px;
        margin: 10px;
        flex-shrink: 0;
    }

    .owner-avatar-small {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        flex-shrink: 0;
        border: 1px solid #eee;
    }

    .news-list-card:hover .news-list-thumbnail {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    .list-title {
        transition: color 0.3s ease;
        font-size: 1.1rem;
    }

    .news-list-card:hover .list-title {
        color: var(--accent-color, #007bff) !important;
    }

    .list-excerpt {
        line-height: 1.4;
    }

    .btn-detail-small {
        font-size: 0.75rem;
        font-weight: 600;
        color: #666;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid #ddd;
        padding: 2px 10px;
        border-radius: 4px;
    }

    .btn-detail-small:hover {
        color: var(--accent-color, #007bff);
        border-color: var(--accent-color, #007bff);
    }

    /* Animation */
    .news-list-wrapper {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 576px) {
        .news-list-card {
            flex-direction: row; /* Keep horizontal on mobile if image is small enough */
        }
        .news-list-img-box {
            width: 100px;
            min-width: 100px;
            height: 100px;
        }
        .list-excerpt {
            display: none; /* Hide excerpt on very small screens to save space */
        }
        .price-box {
            padding-left: 1rem !important;
        }
    }

    .hover-zoom {
        transition: transform 0.3s ease;
        cursor: zoom-in;
    }

    .hover-zoom:hover {
        transform: scale(1.02);
    }

    .alur-pendaftaran .image-box {
        border: 2px solid #f8f9fa;
        transition: all 0.3s ease;
    }

    .alur-pendaftaran .image-box:hover {
        border-color: var(--accent-color, #007bff);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush