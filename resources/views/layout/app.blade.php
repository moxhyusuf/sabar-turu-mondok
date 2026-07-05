<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    @stack('styles')
</head>
<style>
    .marquee-container {
        width: 100%;
        overflow: hidden;
        background: linear-gradient(90deg, #0d6efd, #20c997);
        padding: 12px 0;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
    }

    .marquee-text {
        display: inline-block;
        white-space: nowrap;
        padding-left: 100%;
        font-weight: 600;
        font-size: 1.1rem;
        color: #fff;
        animation: marquee 15s linear infinite;
    }

    @keyframes marquee {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .highlight-name {
        color: #ffd43b;
        /* emas */
        font-weight: 700;
    }

    @media (max-width: 768px) {
        table.table td {
            word-break: break-word;
            white-space: normal;
        }
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{-- Preloader --}}
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets/img/sabar.jpg') }}" alt="" height="60" width="60">
        </div>

        {{-- Navbar --}}
        @include('layout.partials.navbar')

        {{-- Sidebar --}}
        @include('layout.partials.sidebar')

        {{-- Content --}}
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        {{-- Footer --}}
        @include('layout.partials.footer')

        {{-- Control Sidebar --}}
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <!-- JS -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

    <!-- FIX: Hapus backrop modal nyangkut -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
        });
    </script>

    <!-- AUTO HIDE ALERT -->
    <script>
        setTimeout(() => {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = "opacity 0.5s";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);
    </script>


    @stack('scripts')
</body>

</html>
