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
                <h1>Tentang Kami</h1>
                <p>Inovasi digital untuk menciptakan rumah pemondokan yang tertib dan aman bagi masyarakat Probolinggo.</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="current">Tentang Kami</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- About Section -->
        <section id="why-us" class="why-us section">

            <div class="container">

                <!-- Main Content Grid -->
                <div class="content-grid">
                    <div class="row g-4 align-items-stretch">

                        <!-- About Section -->
                        <div class="col-lg-6">
                            <div class="about-block">
                                <div class="about-header">
                                    <span class="section-badge">Tentang Kami</span>
                                    <h3>Tentang Sabar Turu Mondok </h3>
                                </div>
                                <div class="about-content">
                                    <p>SABAR TURU MONDOK merupakan sebuah inovasi dan solusi untuk menjaga bersama sama terkait ketentraman dan ketertiban dalam kehidupan bermasyarakat. </p>
                                    <p>Dengan satu data barcode diharapkan juga mampu mengendalikan pengendalian dan penetiban administrasi kependudukan khususnya dari bagi pelaku usaha rumah pemondokan.</p>
                                    <p>Sebagai salah satu perangkat daerah, Kecamatan mempunyai sebuah kewajiban untuk memberikan pelayanan terbaik kepada masyarakat dan bersama sama mewujudkan dan membangun kota Probolinggo yang AMANAH.</p>


                                </div>
                            </div>
                        </div>

                        <!-- Image Showcase -->
                        <div class="col-lg-6">
                            <div class="image-showcase">
                                <div class="main-image">
                                    <img src="assets/img/STM.jpg" alt="Travel Adventure" class="img-fluid rounded-3">
                                    <div class="overlay-badge">
                                        <div class="badge-content">
                                            <i class="bi bi-award-fill"></i>
                                            <div class="badge-text">
                                                <strong>Award Winner</strong>
                                                <span>Best Travel Agency 2024</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="floating-card">
                                    <img src="assets/img/travel/misc-8.webp" alt="Happy Travelers" class="img-fluid rounded-2">
                                    <div class="card-content">
                                        <div class="rating">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <span>4.9/5</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Main Content Grid -->

                <!-- Why Choose Us Section -->

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