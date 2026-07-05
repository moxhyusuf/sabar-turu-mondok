<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Tentang Kami | STM</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/sabar.jpg') }}" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: TravelTime
  * Template URL: https://bootstrapmade.com/traveltime-bootstrap-travel-template/
  * Updated: Jul 28 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="about-page">

    {{-- HEADER --}}
    @include('layouts_user.partials.header')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" style="background-image: url(assets/img/travel/sabarturu.jpg);">
            <div class="container position-relative">
                <h1>Rumah Pemodokkan</h1>
                <p>Inovasi digital untuk menciptakan rumah pemondokan yang tertib dan aman bagi masyarakat Probolinggo.</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="current">Rumah Pemodokkan</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- destination Section -->
        <section id="featured-destinations" class="featured-destinations section">

            <!-- Section Title -->
            <div class="container section-title">
                <h2>Rumah Pemondokan</h2>
                <div><span>Yang ada di Wilayah</span> <span class="description-title">Kecamatan Kanigaran Probolinggo</span></div>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row mb-4">
                    <div class="col-12">
                        <form action="{{ url('/pemondokan') }}" method="GET" class="d-flex shadow-sm rounded">
                            <input type="text" name="keyword" class="form-control me-2" placeholder="Cari kos berdasarkan nama, wilayah, harga, dll..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
                            @if(request('keyword'))
                                <a href="{{ url('/pemondokan') }}" class="btn btn-secondary ms-2">Reset</a>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="row gy-4">

                    @forelse ($items as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="destination-card">

                            {{-- Jenis Kost - Badge Atas --}}
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

                                {{-- Nama Kost --}}
                                <h5 class="fw-bold mb-1">
                                    {{ $item->nama_kost }}
                                </h5>
                                @if(!empty($item->type_kamar) && $item->type_kamar != '-')
                                    <h6 class="text-secondary mb-1" style="font-size: 0.9rem;">{{ $item->type_kamar }}</h6>
                                @endif

                                {{-- Kelurahan --}}
                                <p class="text-primary fw-semibold mb-1">
                                    {{ $item->kelurahan }}
                                </p>

                                {{-- Alamat --}}
                                <p class="text-muted small">
                                    {{ Str::limit($item->alamat, 60) }}
                                </p>

                                {{-- Harga more standout --}}
                                <p class="fw-bold fs-5 text-dark mb-2">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    <span class="text-muted fs-6">/bulan</span>
                                </p>

                                {{-- Total Kamar + Detail --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-info text-dark">
                                        {{ $item->kamar_tersedia }} Sisa Kamar
                                    </span>

                                    <a href="{{ route('detailkost', $item->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        Detail <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ url('/booking/' . $item->id) }}" class="btn btn-primary w-100"><i class="bi bi-cart"></i> Pesan Kamar</a>
                                </div>

                            </div>

                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted">Belum ada data kost terdaftar</p>
                    @endforelse

                </div>

            </div>


        </section><!-- /Featured Destinations Section -->


    </main>


    {{-- FOOTER --}}
    @include('layouts_user.partials.footer')


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>