@php
    $hideExtraSection = true;
@endphp
@extends('layouts_user.app')
@section('content')

<main class="main" style="background-color: #f8f9fa;">
    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url('{{ asset('assets/img/travel/sabarturu.jpg') }}'); border-bottom-left-radius: 40px; border-bottom-right-radius: 40px; margin-bottom: -50px; padding-bottom: 80px;">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Pesan Kamar</h1>
            <p class="lead">Selesaikan reservasi Anda untuk Kost impian.</p>
        </div>
    </div>

    <section class="section">
        <div class="container position-relative" style="z-index: 10;">
            <div class="row gy-4">

                <!-- Kiri: Info Kost -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <div class="position-relative">
                            @if($kost->images->count())
                            <img src="{{ asset('storage/'.$kost->images->first()->image_path) }}" class="img-fluid w-100" style="object-fit: cover; height: 350px;" alt="Gambar Kost">
                            @else
                            <img src="{{ asset('assets/img/travel/sabarturu.jpg') }}" class="img-fluid w-100" style="object-fit: cover; height: 350px;" alt="No Image">
                            @endif
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.8));"></div>
                            <div class="position-absolute bottom-0 start-0 p-4 w-100 text-white">
                                <span class="badge bg-primary mb-2 fs-6">{{ ucfirst($kost->jenis_kost) }}</span>
                                <h2 class="fw-bold mb-1">{{ $kost->nama_kost }}</h2>
                                <p class="mb-0 text-light"><i class="bi bi-geo-alt-fill me-1"></i> {{ $kost->alamat }}</p>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Rincian Informasi</h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                            <i class="bi bi-person-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-0">Pemilik</p>
                                            <h6 class="mb-0 fw-bold">{{ $kost->nama_pemilik }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                            <i class="bi bi-telephone-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-0">Kontak</p>
                                            <h6 class="mb-0 fw-bold">{{ $kost->contact_person }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                            <i class="bi bi-door-open-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-0">Kamar Tersedia</p>
                                            <h6 class="mb-0 fw-bold">{{ $kost->kamar_tersedia ?? $kost->jumlah_kamar }} Kamar</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                            <i class="bi bi-tags-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-0">Harga per Bulan</p>
                                            <h6 class="mb-0 fw-bold">Rp {{ number_format($kost->harga, 0, ',', '.') }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Form Booking -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden sticky-top" style="top: 100px;">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                            <h4 class="fw-bold text-center">Detail Reservasi</h4>
                            <p class="text-muted text-center small">Pilih tanggal masuk dan keluar untuk memesan kos ini.</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="bg-light p-3 rounded-3 mb-4 border border-primary border-opacity-25">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Estimasi Biaya</span>
                                    <span class="fw-bold fs-5 text-primary">Rp {{ number_format($kost->harga, 0, ',', '.') }} <small class="text-muted fs-6 fw-normal">/ bln</small></span>
                                </div>
                                <p class="small text-muted mb-0"><i class="bi bi-info-circle me-1"></i> Biaya akan dihitung detail setelah verifikasi owner.</p>
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('user.booking.identity') }}" method="GET">
                                <input type="hidden" name="kost_id" value="{{ $kost->id }}">

                                <div class="form-floating mb-3">
                                    <input type="date" name="tanggal_masuk" class="form-control focus-ring focus-ring-primary" id="tanggalMasuk" required>
                                    <label for="tanggalMasuk" class="text-muted"><i class="bi bi-calendar-check me-2"></i>Tanggal Masuk</label>
                                </div>

                                <div class="form-floating mb-4">
                                    <input type="date" name="tanggal_keluar" class="form-control focus-ring focus-ring-primary" id="tanggalKeluar" required>
                                    <label for="tanggalKeluar" class="text-muted"><i class="bi bi-calendar-x me-2"></i>Tanggal Keluar</label>
                                </div>

                                @if($kost->kamar_tersedia > 0)
                                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold fs-5 shadow-sm btn-bounce" style="transition: transform 0.2s;">
                                        Ajukan Pemesanan Kamar <i class="bi bi-arrow-right-short fs-4 align-middle ms-1"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary w-100 py-3 rounded-pill fw-bold fs-5 shadow-sm" disabled>
                                        Kamar Penuh
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<style>
    .btn-bounce:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(13, 110, 253, 0.25) !important;
    }

    .focus-ring:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .15);
    }
</style>
@endsection