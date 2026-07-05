@extends('layouts_user.app')
@section('content')

<main class="main" style="background-color: #f8f9fa; min-height: 80vh;">
    <div class="page-title dark-background" style="background-image: url('{{ asset('assets/img/travel/sabarturu.jpg') }}'); border-bottom-left-radius: 40px; border-bottom-right-radius: 40px; margin-bottom: -50px; padding-bottom: 80px;">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Cek Transaksi Booking</h1>
            <p class="lead">Masukkan kode booking Anda untuk melihat status pemesanan.</p>
        </div>
    </div>

    <section class="section mt-5 pt-5">
        <div class="container position-relative" style="z-index: 10;">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 p-4 p-lg-5">
                        
                        <h4 class="fw-bold text-center mb-4"><i class="bi bi-search text-primary"></i> Lacak Booking</h4>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if(session('last_booking_kode'))
                            <div class="alert alert-info d-flex align-items-center justify-content-between rounded-4 mb-4 shadow-sm border-0">
                                <div>
                                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                                    <strong>Anda memiliki booking sebelumnya!</strong>
                                </div>
                                <a href="{{ route('guest.transaksi.show', session('last_booking_kode')) }}" class="btn btn-outline-primary btn-sm rounded-pill fw-bold">
                                    Lanjutkan Booking <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @endif

                        <form action="{{ route('guest.cek_booking.process') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-4">
                                <input type="text" name="identifier" class="form-control focus-ring focus-ring-primary" id="kodeBooking" placeholder="Contoh: XJ8K9P / Email / No HP" required style="text-transform: uppercase;">
                                <label for="kodeBooking" class="text-muted"><i class="bi bi-upc-scan me-2"></i>Kode Booking / Email / No HP</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold fs-5 shadow-sm">
                                Lacak Sekarang <i class="bi bi-arrow-right-short ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
