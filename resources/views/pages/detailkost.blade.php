<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $kost->nama_kost }}{{ !empty($kost->type_kamar) && $kost->type_kamar != '-' ? ' - ' . $kost->type_kamar : '' }} | STM</title>

    <link href="{{ asset('assets/img/sabar.jpg') }}" rel="icon">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    
    <style>
        .facility-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 15px;
        }
        .facility-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background-color: #f0f7ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 18px;
        }
        .rule-list {
            padding-left: 20px;
        }
        .rule-list li {
            margin-bottom: 8px;
            font-size: 15px;
        }
        .info-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
            padding: 24px;
        }
    </style>
</head>

<body>

    @include('layouts_user.partials.header')

    <main class="main">

        {{-- JUDUL PAGE --}}
        <div class="page-title dark-background" style="background-image: url('{{ asset('assets/img/travel/sabarturu.jpg') }}');">
            <div class="container">
                <h1>{{ $kost->nama_kost }}{{ !empty($kost->type_kamar) && $kost->type_kamar != '-' ? ' - ' . $kost->type_kamar : '' }}</h1>
                <p>Kost {{ ucfirst($kost->jenis_kost) }} di wilayah {{ $kost->kelurahan }}</p>
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
                                "speed": 600,
                                "autoplay": {
                                    "delay": 5000
                                },
                                "slidesPerView": "auto",
                                "pagination": {
                                    "el": ".swiper-pagination",
                                    "type": "bullets",
                                    "clickable": true
                                },
                                "breakpoints": {
                                    "320": {
                                        "slidesPerView": 1,
                                        "spaceBetween": 40
                                    },
                                    "1200": {
                                        "slidesPerView": 2,
                                        "spaceBetween": 20
                                    }
                                }
                            }
                        </script>
                        <div class="swiper-wrapper align-items-center">
                            @forelse ($kost->images as $img)
                            <div class="swiper-slide">
                                <div class="gallery-item">
                                    <div class="gallery-img">
                                        <a class="glightbox" data-gallery="images-gallery" href="{{ asset('storage/'.$img->image_path) }}">
                                            <img src="{{ asset('storage/'.$img->image_path) }}" alt="Gambar Kost" style="width: 100%; height: 350px; object-fit: cover; display: block;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-danger w-100 py-5">Belum ada gambar.</p>
                            @endforelse
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- INFO KOST --}}
        <section class="section pt-0">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-8">

                        <div class="info-card mb-4">
                            <h4 class="fw-bold">{{ $kost->nama_kost }}{{ !empty($kost->type_kamar) && $kost->type_kamar != '-' ? ' - ' . $kost->type_kamar : '' }}</h4>
                            <p class="text-muted">{{ $kost->alamat }}</p>

                            <p class="fs-5 fw-bold text-dark mt-3">
                                Rp {{ number_format($kost->harga, 0, ',', '.') }} <span class="fs-6 fw-normal text-muted">/ bulan</span>
                            </p>

                            <hr>

                            <div class="row text-center mt-3">
                                <div class="col-4 border-end">
                                    <h6 class="text-muted mb-1" style="font-size: 13px;">Sisa Kamar</h6>
                                    <p class="fw-bold mb-0 text-dark">{{ $kost->kamar_tersedia }} Kamar</p>
                                </div>
                                <div class="col-4 border-end">
                                    <h6 class="text-muted mb-1" style="font-size: 13px;">Total Kamar</h6>
                                    <p class="fw-bold mb-0 text-dark">{{ $kost->jumlah_kamar }} Kamar</p>
                                </div>
                                <div class="col-4">
                                    <h6 class="text-muted mb-1" style="font-size: 13px;">Tipe Bangunan</h6>
                                    <p class="fw-bold mb-0 text-dark">{{ $kost->lokasi_pemondokan == 'satu_atap' ? 'Satu Atap' : 'Terpisah' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- FASILITAS --}}
                        <div class="info-card mb-4">
                            <h5 class="fw-bold mb-4">Fasilitas Kos</h5>

                            @php
                            $fas = $kost->fasilitas;

                            // Pisahkan Fasilitas Kamar dan Fasilitas Umum
                            $fasKamar = [
                                'kasur' => ['Kasur', 'bi-pci-card'],
                                'bantal' => ['Bantal', 'bi-bag'],
                                'guling' => ['Guling', 'bi-layout-sidebar'],
                                'lemari' => ['Lemari', 'bi-door-closed'],
                                'kursi' => ['Kursi', 'bi-person-seat'],
                                'meja' => ['Meja Belajar', 'bi-table'],
                                'meja_rias' => ['Meja Rias', 'bi-mirror'],
                                'ac_kipas' => ['AC / Kipas', 'bi-fan'],
                                'meteran_listrik' => ['Meteran Listrik', 'bi-lightning'],
                            ];

                            $fasUmum = [
                                'lahan_parkir' => ['Lahan Parkir', 'bi-p-circle'],
                                'pagar' => ['Pagar', 'bi-bricks'],
                                'cctv' => ['CCTV', 'bi-camera-video'],
                                'wifi' => ['Wi-Fi', 'bi-wifi'],
                                'dapur' => ['Dapur', 'bi-cup-hot'],
                                'mesin_cuci' => ['Mesin Cuci', 'bi-droplet'],
                                'r_jemur' => ['Ruang Jemur', 'bi-sun'],
                                'penjaga' => ['Penjaga Kos', 'bi-person-badge'],
                            ];
                            @endphp

                            <div class="row">
                                <div class="col-md-6 mb-4 mb-md-0">
                                    <h6 class="fw-semibold mb-3 border-bottom pb-2">Fasilitas Kamar</h6>
                                    <div class="row">
                                        @foreach ($fasKamar as $key => $info)
                                        @if($fas && $fas->$key)
                                        <div class="col-12">
                                            <div class="facility-item">
                                                <div class="facility-icon"><i class="bi {{ $info[1] }}"></i></div>
                                                <span>{{ $info[0] }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-3 border-bottom pb-2">Fasilitas Umum</h6>
                                    <div class="row">
                                        @foreach ($fasUmum as $key => $info)
                                        @if($fas && $fas->$key)
                                        <div class="col-12">
                                            <div class="facility-item">
                                                <div class="facility-icon"><i class="bi {{ $info[1] }}"></i></div>
                                                <span>{{ $info[0] }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach

                                        {{-- Fasilitas Custom --}}
                                        @if($fas && $fas->fasilitas_custom)
                                        @foreach($fas->fasilitas_custom as $custom)
                                        <div class="col-12">
                                            <div class="facility-item">
                                                <div class="facility-icon"><i class="bi bi-patch-check"></i></div>
                                                <span>{{ $custom }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PERATURAN --}}
                        @if(!empty($kost->peraturan_kost))
                        <div class="info-card mb-4">
                            <h5 class="fw-bold mb-4">Peraturan Kos</h5>
                            <div class="alert alert-light border">
                                <ul class="rule-list mb-0">
                                    @php
                                        // Memisahkan text berdasarkan baris baru
                                        $rules = explode("\n", $kost->peraturan_kost);
                                    @endphp
                                    @foreach($rules as $rule)
                                        @if(trim($rule) != '')
                                            <li>{{ trim($rule) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                    </div>

                    {{-- SIDEBAR --}}
                    <div class="col-lg-4">
                        <div class="info-card" style="position: sticky; top: 85px; z-index: 10;">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="bi bi-person-fill fs-3 text-secondary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Pemilik Kos</h6>
                                    <p class="text-muted mb-0">{{ $kost->nama_pemilik }}</p>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <a
                                href="https://wa.me/{{ preg_replace('/\D/', '', $kost->contact_person) }}?text={{ urlencode('Halo, saya ingin bertanya tentang kost '.$kost->nama_kost.' yang beralamat di '.$kost->alamat) }}"
                                target="_blank"
                                class="btn btn-success d-flex align-items-center mb-3 justify-content-center py-2 fw-bold">
                                <i class="bi bi-whatsapp fs-4 me-2"></i> Hubungi via WhatsApp
                            </a>

                            <!-- Pesan Kamar -->
                            <a href="{{ url('/booking/'.$kost->id) }}" class="btn btn-primary w-100 py-2 fs-5 fw-semibold mb-4 rounded-3 shadow-sm d-flex justify-content-center align-items-center">
                                <i class="bi bi-cart-check me-2"></i> Pesan Kamar
                            </a>

                            <hr>

                            <!-- Maps -->
                            <div class="map-responsive mt-4">
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

        {{-- REKOMENDASI --}}
        @if(isset($rekomendasi) && $rekomendasi->count() > 0)
        <section class="section pt-0 pb-5">
            <div class="container">
                <h4 class="fw-bold mb-4 border-bottom pb-3">Kamar Rekomendasi Lain</h4>
                <div class="row gy-4">
                    @foreach ($rekomendasi as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="destination-card border rounded-4 bg-white shadow-sm overflow-hidden position-relative h-100 d-flex flex-column" style="transition: all 0.3s ease;">
                            
                            {{-- Badge --}}
                            <span class="badge bg-primary position-absolute m-3" style="z-index:10; top: 0; left: 0; font-size: 12px; padding: 6px 12px;">
                                {{ ucfirst($item->jenis_kost) }}
                            </span>
                            
                            <div class="image-wrapper" style="height: 220px; overflow: hidden;">
                                @if($item->images->count())
                                <img src="{{ asset('storage/'.$item->images->first()->image_path) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="Gambar Kost" style="transition: transform 0.4s ease;">
                                @else
                                <img src="{{ asset('assets/img/no-image.png') }}" class="img-fluid w-100 h-100 object-fit-cover" alt="No Image">
                                @endif
                            </div>
                            
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <h5 class="fw-bold mb-1 text-dark">
                                    {{ $item->nama_kost }}
                                </h5>
                                @if(!empty($item->type_kamar) && $item->type_kamar != '-')
                                    <h6 class="text-secondary mb-2" style="font-size: 0.9rem;">{{ $item->type_kamar }}</h6>
                                @endif
                                
                                <p class="text-muted small mb-3"><i class="bi bi-geo-alt"></i> {{ $item->kelurahan }}</p>
                                
                                <div class="mt-auto">
                                    <p class="fw-bold text-dark fs-5 mb-3">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }} <span class="text-muted fw-normal" style="font-size: 0.8rem;">/ bulan</span>
                                    </p>
                                    
                                    <a href="{{ route('detailkost', $item->id) }}" class="btn btn-outline-primary w-100 rounded-3 fw-semibold">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

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
            
            // Hover effect for recommendations
            document.querySelectorAll('.destination-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
                    const img = this.querySelector('img');
                    if(img) img.style.transform = 'scale(1.05)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.05)';
                    const img = this.querySelector('img');
                    if(img) img.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>

</html>