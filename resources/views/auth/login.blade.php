<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akun</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome (icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #2aa4d8, #1b7fb5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            max-width: 800px;
            border-radius: 12px;
            overflow: hidden;
            background: #e6e6e6;
        }

        /* ===== KIRI (GAMBAR) ===== */
        .login-image {
            background: #ddd;
            padding: 10px;
            /* DIPERKECIL → jarak tengah menyempit */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-image img {
            width: 70%;
            height: auto;
            /* supaya proporsional */
            object-fit: contain;
            border-radius: 6px;
        }

        /* ===== KANAN (FORM) ===== */
        .login-form {
            padding: 50px 35px 40px;
            /* form agak turun */
        }

        .login-form h3 {
            font-weight: bold;
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #999;
            border-radius: 0;
            background: transparent;
        }

        .form-control:focus {
            box-shadow: none;
            border-bottom-color: #0d6efd;
        }

        .input-group-text {
            background: transparent;
            border: none;
            border-bottom: 2px solid #999;
            border-radius: 0;
        }

        /* ===== TOMBOL LOGIN ===== */
        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            margin-top: 30px;
            /* TOMBOL DITURUNKAN */
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .login-image {
                display: none;
            }

            .login-form {
                padding: 35px 25px;
            }
        }

        .alert {
            padding: 8px 10px;
            /* perkecil dalamnya */
            font-size: 12px;
            /* kecilkan tulisan */
            margin-bottom: 8px;
            /* jarak bawah */
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card shadow login-card mx-auto">
            <div class="row g-0">

                <!-- GAMBAR KIRI -->
                <div class="col-md-6 login-image">
                    <img src="{{ asset('assets/img/kota.png') }}"
                        alt="Kota Probolinggo">
                </div>

                <!-- FORM LOGIN -->
                <div class="col-md-6 login-form">

                    <div class="mb-3 text-center">
                        <strong>Login</strong>
                        <p class="text-muted mb-0">Aplikasi Sabar-Turu-Mondok</p>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf

                        <div class="mb-4 input-group">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                            <input type="text" name="username" class="form-control"
                                placeholder="Masukkan username" required>
                        </div>

                        <div class="mb-2 input-group">
                            <span class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukkan password" required>
                        </div>

                        <div class="text-end mb-3">
                            <a href="#" class="small"></a>
                        </div>

                        <div class="text-end mb-3">
                            <a href="#" class="small"></a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-login">
                            login
                        </button>

                        <p class="text-center mt-3 small">
                            Belum punya akun? <a href="/register">Daftar</a>
                            <br>
                            Kembali ke <a href="{{ url('/') }}">Beranda</a>
                        </p>


                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = "4s";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);
    </script>

</body>

</html>