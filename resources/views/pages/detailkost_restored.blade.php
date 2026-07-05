The following code has been modified to include a line number before every line, in the format: <line_number>: <original_line>. Please note that any changes targeting the original code should remove the line number, colon, and leading space.
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $kost->nama_kost }} | STM</title>

    <link href="{{ asset('assets/img/sabar.jpg') }}" rel="icon">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body>

    @include('layouts_user.partials.header')

    <main class="main">

        {{-- JUDUL PAGE --}}
        <div class="page-title dark-background" style="background-image: url('{{ asset('assets/img/travel/sabarturu.jpg') }}');">
            <div class="container">
                <h1>{{ $kost->nama_kost }}</h1>
                <p>Kost {{ $kost->jenis_kost }} di wilayah {{ $kost->kelurahan }}</p>
            </div>
        </div>

        {{-- SLIDER GALERI --}}
        <section id="gallery-slider" class="gallery-slider pb-0 pt-0">
            <div class="container">
                <div class="gallery-container">
                    <div class="swiper init-swiper">

                        <script type="applica
<truncated 7526 bytes>
                    class="btn btn-success d-flex align-items-center mb-3">
                                <i class="bi bi-whatsapp fs-4 me-2"></i> Hubungi via WhatsApp
                            </a>


                            <!-- Maps -->
                            <div class="map-responsive">
                                <iframe
                                    src="https://www.google.com/maps?q={{ urlencode($kost->alamat) }}&output=embed"
                                    width="100%" height="250"
                                    style="border:0; border-radius: 8px;"
                                    allowfullscreen loading="lazy">
                                </iframe>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>

    @include('layouts_user.partials.footer')

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".init-swiper").forEach(swiperElement => {

                let configElement = swiperElement.querySelector(".swiper-config");
                if (!configElement) return;

                let config = JSON.parse(configElement.innerHTML.trim());

                new Swiper(swiperElement, config);
            });
        });
    </script>


</body>

</html>
The above content shows the entire, complete file contents of the requested file.

