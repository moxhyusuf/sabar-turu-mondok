<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="{{ asset('assets/img/sabar.jpg') }}" alt="Logo Sabar Turu Mondok" class="me-2" style="height: 50px;">
            <h1 class="sitename m-0">Sabar Turu Mondok</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul class="">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">Tentang Kami</a></li>
                <li><a href="{{ url('/alur') }}" class="{{ request()->is('alur') ? 'active' : '' }}">Alur Pendaftaran</a></li>
                <li><a href="{{ url('/pemondokan') }}" class="{{ request()->is('pemondokkan') ? 'active' : '' }}">Pemondokkan</a></li>
                <li><a href="{{ url('/kontak') }}" class="{{ request()->is('kontak') ? 'active' : '' }}">Kontak</a></li>

            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted" href="{{ url('/login') }}" target="_blank">Login</a>
    </div>
</header>