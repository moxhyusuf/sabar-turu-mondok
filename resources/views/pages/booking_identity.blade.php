@extends('layouts_user.app')
@section('content')

<main class="main" style="background-color: #f8f9fa;">
    <div class="page-title dark-background" style="background-image: url('{{ asset('assets/img/travel/sabarturu.jpg') }}'); border-bottom-left-radius: 40px; border-bottom-right-radius: 40px; margin-bottom: -50px; padding-bottom: 80px;">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Data Diri Penyewa</h1>
            <p class="lead">Lengkapi data diri Anda untuk melanjutkan proses pemesanan.</p>
        </div>
    </div>

    <section class="section">
        <div class="container position-relative" style="z-index: 10;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                            <h4 class="fw-bold text-center">Form Identitas Penyewa</h4>
                            <p class="text-muted text-center small">Pemesanan untuk Kost: <strong>{{ $kost->nama_kost }}</strong></p>
                        </div>
                        <div class="card-body p-4">
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('user.booking.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="kost_id" value="{{ $bookingData['kost_id'] }}">
                                <input type="hidden" name="tanggal_masuk" value="{{ $bookingData['tanggal_masuk'] }}">
                                <input type="hidden" name="tanggal_keluar" value="{{ $bookingData['tanggal_keluar'] }}">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Lengkap" required>
                                            <label for="nama">Nama Lengkap</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Nomor HP/WA" required>
                                            <label for="no_hp">Nomor HP / WA</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Email Aktif">
                                            <label for="email">Email Aktif (Opsional)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat Asal" style="height: 100px" required></textarea>
                                            <label for="alamat">Alamat Asal Lengkap</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="ktp" class="form-label text-muted small">Upload KTP (Opsional, Format: jpg/jpeg/png, Max 2MB)</label>
                                        <input class="form-control form-control-lg" type="file" name="ktp" id="ktp" accept=".jpg,.jpeg,.png">
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                                    <a href="{{ route('user.booking.create', $bookingData['kost_id']) }}" class="btn btn-outline-secondary rounded-pill px-4">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                                        Selesaikan Booking <i class="bi bi-check2-circle ms-1"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
