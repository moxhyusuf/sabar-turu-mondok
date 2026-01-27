<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link d-flex align-items-center">
        <img src="{{ asset('assets/img/sabar.jpg') }}" alt="Logo Sabar-Turu-Mondok"
            style="height: 20px; width: auto; border-radius: 0; box-shadow: none;">
        <span class="ml-2 text-white" style="font-weight: 500;">Sabar-Turu-Mondok</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-2 mb-3 d-flex justify-content-center">
            <div class="info text-center">
                <div class="d-block text-white">
                    @php
                    $jam = \Carbon\Carbon::now('Asia/Jakarta')->format('H');
                    @endphp


                    @if ($jam >= 5 && $jam < 11)
                        Selamat pagi,
                        @elseif ($jam>= 11 && $jam < 15)
                            Selamat siang,
                            @elseif ($jam>= 15 && $jam < 18)
                                Selamat sore,
                                @else
                                Selamat malam,
                                @endif
                                </div>

                                <div class="d-block fw-bold text-warning">
                                    {{ Auth::user()->nama }}
                                </div>
                </div>
            </div>


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

                    {{-- Menu Dashboard tampil untuk semua --}}
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    {{-- Jika ADMIN → Semua menu muncul --}}
                    @if(auth()->user()->role === 'admin')

                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Petugas</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('tentang_kami.index') }}" class="nav-link {{ request()->routeIs('tentang_kami.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-info-circle"></i>
                            <p>Tentang Kami</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('alur_pendaftaran.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Alur Pendaftaran</p>
                        </a>
                    </li>

                    @endif

                    {{-- Untuk PEMILIK KOST, PERPAJAKAN, PERIJINAN → Hanya menu Rumah Kost tampil --}}
                    @if(in_array(auth()->user()->role, ['admin', 'pemilik_dekost', 'perpajakan', 'perijinan']))
                    <li class="nav-item">
                        <a href="{{ route('kost.index') }}" class="nav-link {{ request()->routeIs('kost.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Rumah Kost</p>
                        </a>
                    </li>
                    @endif

                    {{-- Logout untuk semua role --}}
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="nav-link text-left btn btn-link">
                                <i class="nav-icon fas fa-arrow-right"></i>
                                <p>Logout</p>
                            </button>
                        </form>
                    </li>

                </ul>
            </nav>

            <!-- /.sidebar-menu -->
        </div>

        <!-- /.sidebar -->
</aside>
