<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'sabar turu Mondok')</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/sabar.jpg') }}" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>

    </style>

</head>

<body class="@yield('body_class', 'index-page')">

    {{-- HEADER --}}
    @include('layouts_user.partials.header')

    <main class="main">
        @yield('content')
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

            <!-- Section Title -->
            <div class="container section-title">
                <h2>Rumah Pemondokan Populer</h2>
                <div><span>di</span>
                    <span class="description-title">Kecamatan Kanigaran Kota Probolinggo</span>
                </div>
            </div>

            <div class="container">
                <div class="row gy-4">

                    @forelse ($items as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="destination-card">

                            {{-- Jenis Kost - Badge --}}
                            <span class="badge bg-primary position-absolute m-2" style="z-index:10;">
                                {{ ucfirst($item->jenis_kost) }}
                            </span>

                            <div class="image-wrapper">
                                @if($item->images->count())
                                <img src="{{ asset('storage/'.$item->images->first()->image_path) }}"
                                    class="img-fluid" alt="Gambar Kost">
                                @else
                                <img src="{{ asset('assets/img/no-image.png') }}"
                                    class="img-fluid" alt="No Image">
                                @endif
                            </div>

                            <div class="content mt-2">

                                <h5 class="fw-bold mb-1">{{ $item->nama_kost }}</h5>

                                <p class="text-primary fw-semibold mb-1">{{ $item->kelurahan }}</p>

                                <p class="text-muted small">
                                    {{ Str::limit($item->alamat, 60) }}
                                </p>

                                <p class="fw-bold fs-5 text-dark mb-2">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    <span class="text-muted fs-6">/bulan</span>
                                </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info text-dark">
                                        {{ $item->jumlah_kamar }} Kamar
                                    </span>

                                    <a href="{{ route('kost.detail', $item->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        Detail <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted">Belum ada data kost terdaftar</p>
                    @endforelse

                </div>
            </div>
        </section>



    </main>

    {{-- FOOTER --}}
    @include('layouts_user.partials.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>