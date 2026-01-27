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
                <h1>Hubungi Kami</h1>
                <p></p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="current">Hubungi Kami</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- About Section -->
        <section id="contact" class="contact section">

            <div class="container">
                <div class="contact-wrapper">
                    <div class="contact-info-panel">
                        <div class="contact-info-header">
                            <h3>Hubungi Kami</h3>

                        </div>

                        <div class="contact-info-cards">
                            <div class="info-card">
                                <div class="icon-container">
                                    <i class="bi bi-pin-map-fill"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Lokasi</h4>
                                    <p>Jl. Slamet Riyadi No.97a, Kanigaran</p>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="icon-container">
                                    <i class="bi bi-globe"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Website</h4>
                                    <p>kec-kanigaran.probolinggokota.go.id</p>
                                </div>
                            </div>



                            <div class="info-card">
                                <div class="icon-container">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Jam Kerja</h4>
                                    <p>Senin-Jum'at: 07.30 - 16.00 WIB</p>
                                </div>
                            </div>
                        </div>

                        <div class="social-links-panel">
                            <h5>Follow Us</h5>
                            <div class="social-icons">
                                <a href="#"><i class="bi bi-facebook"></i></a>
                                <a href="https://kec-kanigaran.probolinggokota.go.id/"><i class="bi bi-globe"></i></a>
                                <a href="https://www.instagram.com/kecamatankanigaran?igsh=NGFxYWxjMTU0OGJ1"><i class="bi bi-instagram"></i></a>
                                <a href="https://youtube.com/@salamchannel?si=UW6VQdoJDD96rWw6"><i class="bi bi-youtube"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="contact-form-panel">
                        <div class="map-container">

                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3011.2384448474527!2d113.2080015735799!3d-7.766946877035712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7ad75ea03c07f%3A0xfc8760ae22cf6df9!2sKantor%20Kecamatan%20Kanigaran!5e1!3m2!1sid!2sid!4v1761794638068!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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