@extends('layouts_user.app')


@section('title', 'Sabar-Turu-Mondok')

@section('content')
<section id="travel-hero" class="travel-hero section dark-background">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 mt-5 mt-lg-0">
                <div class="content text-center">
                    <h1 class="fw-bold">SABAR TURU MONDOK</h1>
                    <p class="lead mt-2">
                        <span><strong>SA</strong>tu <strong>BAR</strong>code un<strong>TU</strong>k <strong>RU</strong>mah <strong>peMONDOK</strong>an</span>
                    </p>
                    <p>Mampu memberikan pelayanan kepada masyarakat untuk selalu tertib administrasi </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <a href="{{ url('/register') }}" class="btn btn-primary" target="_blank">Daftar Sekarang</a>
                        <a href="{{ url('/tours') }}" class="btn btn-outline-light">View</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .hero-text {
        position: relative;
        display: inline-block;
        padding: 0 20px;
        border-left: 3px solid #e50914;
        border-right: 3px solid #e50914;
    }

    .hero-text h1 {
        font-size: 3rem;
        font-weight: 800;
        color: #fff;
        margin: 0;
        letter-spacing: 1px;
    }

    .hero-text .tagline {
        margin-top: 8px;
        color: #fff;
        font-size: 1.2rem;
    }
</style>
@endpush