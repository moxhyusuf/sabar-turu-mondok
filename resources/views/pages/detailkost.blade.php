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

                        <script type="application/json" class="swiper-config">
                            {
                                "loop": true,
                                "speed": 800,
                                "autoplay": {
                                    "delay": 4000
                                },
                                "effect": "coverflow",
                                "grabCursor": true,
                                "centeredSlides": true,
                                "slidesPerView": "auto",
                                "coverflowEffect": {
                                    "rotate": 50,
                                    "stretch": 0,
                                    "depth": 100,
                                    "modifier": 1,
                                    "slideShadows": true
                                },
                                "pagination": {
                                    "el": ".swiper-pagination",
                                    "type": "bullets",
                                    "clickable": true
                                },
                                "navigation": {
                                    "nextEl": ".swiper-button-next",
                                    "prevEl": ".swiper-button-prev"
                                },
                                "breakpoints": {
                                    "320": {
                                        "slidesPerView": 1,
                                        "spaceBetween": 10
                                    },
                                    "768": {
                                        "slidesPerView": 2,
                                        "spaceBetween": 20
                                    },
                                    "1024": {
                                        "slidesPerView": 3,
                                        "spaceBetween": 30
                                    }
                                }
                            }
                        </script>

                        <div class="swiper-wrapper">
                            @forelse ($kost->images as $img)
                            <div class="swiper-slide">
                                <div class="gallery-item">
                                    <div class="gallery-img">
                                        <a class="glightbox" data-gallery="kost-gallery"
                                            href="{{ asset('storage/'.$img->image_path) }}">
                                            <img src="{{ asset('storage/'.$img->image_path) }}" class="img-fluid">
                                            <div class="gallery-overlay">
                                                <i class="bi bi-plus-circle"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-danger">Belum ada gambar.</p>
                            @endforelse
                        </div>

                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>

                    </div>
                </div>
            </div>
        </section>

        {{-- INFORMASI KOST --}}
        <section class="section">
            <div class="container">

                <div class="row gy-4">
                    <div class="col-lg-8">

                        <h4 class="fw-bold">{{ $kost->nama_kost }}</h4>
                        <p class="text-muted">{{ $kost->alamat }}</p>

                        <p class="fs-5 fw-bold">
                            Rp {{ number_format($kost->harga,0,',','.') }} <span class="text-muted fs-6">/bulan</span>
                        </p>

                        <div class="mb-3">
                            <span class="badge bg-info text-dark">{{ $kost->jumlah_kamar }} Kamar</span>
                            <span class="badge bg-primary">{{ ucfirst($kost->jenis_kost) }}</span>
                        </div>

                        <hr>

                        <h5 class="fw-bold mb-3">Fasilitas Kost</h5>

                        @php
                        $fas = $kost->fasilitas;

                        $daftarFasilitas = [
                        'lahan_parkir' => 'Lahan Parkir',
                        'pagar' => 'Pagar',
                        'cctv' => 'CCTV',
                        'ac_kipas' => 'AC / Kipas',
                        'meteran_listrik' => 'Meteran Listrik',
                        'wifi' => 'Wi-Fi',
                        'peraturan_penghuni' => 'Peraturan Penghuni',
                        'penjaga' => 'Penjaga',
                        'kasur' => 'Kasur',
                        'bantal' => 'Bantal',
                        'lemari' => 'Lemari',
                        'guling' => 'Guling',
                        'kursi' => 'Kursi',
                        'meja' => 'Meja Belajar',
                        'meja_rias' => 'Meja Rias',
                        'mesin_cuci' => 'Mesin Cuci',
                        'r_jemur' => 'Ruang Jemur',
                        'dapur' => 'Dapur',
                        ];
                        @endphp

                        <div class="row">
                            @foreach ($daftarFasilitas as $key => $label)
                            @if($fas && $fas->$key)
                            <div class="col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="text-success fw-bold me-2">✔</span>
                                    <span>{{ $label }}</span>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>



                    </div>

                    {{-- SIDEBAR --}}
                    <div class="col-lg-4">
                        <div class="card p-3 shadow-sm">

                            <h6 class="fw-bold mb-2">Pemilik</h6>
                            <p class="mb-2">{{ $kost->nama_pemilik }}</p>

                            <hr>

                            <!-- WhatsApp -->
                            <a
                                href="https://wa.me/{{ preg_replace('/\D/', '', $kost->contact_person) }}?text={{ urlencode('Halo, saya ingin bertanya tentang kost '.$kost->nama_kost.' yang beralamat di '.$kost->alamat) }}"
                                target="_blank"
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