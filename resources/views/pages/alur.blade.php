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
                <h1>Alur Pendaftaran</h1>
                <p>Mari wujudkan ketertiban bersama — daftarkan rumah pemondokan Anda melalui SABAR TURU MONDOK</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="current">Alur Pendaftaran</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- About Section -->
        <section id="why-us" class="why-us section">

            <div class="container">

                <div class="content-grid">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">

                            @if(isset($data) && $data->count() > 0)
                                <div class="d-flex flex-column" style="gap: 40px;">
                                    @foreach($data as $item)
                                        <div class="alur-item">
                                            <h3 class="fw-bold mb-3" style="color: #2c3e50; font-family: 'Poppins', sans-serif;">
                                                {{ $item->title }}
                                            </h3>
                                            @if($item->img)
                                                <img src="{{ asset('storage/' . $item->img) }}"
                                                     alt="{{ $item->title }}"
                                                     class="img-fluid w-100"
                                                     style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); display: block;">
                                            @else
                                                <div class="text-center py-5 bg-light rounded-3 text-muted">
                                                    Tidak ada gambar alur
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center">
                                    <img src="/assets/img/prototype.jpg"
                                        alt="Default Image"
                                        class="img-fluid rounded-3" style="max-width: 500px;">
                                    <p class="text-muted mt-3">Alur pendaftaran belum tersedia.</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>

        </section>


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