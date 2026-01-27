@extends('layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- MARQUEE (MUNCUL UNTUK SEMUA USER) --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="marquee-container">
            <div class="marquee-text">
                <i class="fas fa-bullhorn me-2"></i>
                SELAMAT DATANG,
                <span class="highlight-name">
                    {{ strtoupper(auth()->user()->nama) }}
                </span> DI APLIKASI SABAR-TURU-MONDOK KECAMATAN KANIGARAN KOTA PROBOLINGGO
            </div>
        </div>
    </div>
</div>

{{-- JIKA ADMIN → TAMPIL SEMUA --}}
@auth
@if(auth()->user()->role === 'admin')

<div class="row">

    {{-- Kanigaran --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $dataKelurahan['kanigaran'] }}</h3>
                <p>Kanigaran</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Curahgrinting --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $dataKelurahan['curahgrinting'] }}</h3>
                <p>Curahgrinting</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Kebonsari Wetan --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $dataKelurahan['kebonsari_wetan'] }}</h3>
                <p>Kebonsari Wetan</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Kebonsari Kulon --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $dataKelurahan['kebonsari_kulon'] }}</h3>
                <p>Kebonsari Kulon</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Sukoharjo --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $dataKelurahan['sukoharjo'] }}</h3>
                <p>Sukoharjo</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Tisnonegaran --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $dataKelurahan['tisnonegaran'] }}</h3>
                <p>Tisnonegaran</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- TOTAL --}}
    <div class="col-lg-6 col-12">
        <div class="small-box bg-dark">
            <div class="inner text-center">
                <h2>{{ $totalKost }}</h2>
                <p>Total Kost di Kecamatan Kanigaran</p>
            </div>
            <div class="icon"> <i class="ion ion-stats-bars"></i> </div>
        </div>
    </div>

</div>

@endif
@endauth

@endsection
