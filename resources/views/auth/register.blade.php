<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">



    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #2aa4d8, #1b7fb5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            max-width: 900px;
            width: 100%;
            background: #e6e6e6;
            border-radius: 12px;
            padding: 35px;
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

        .btn-register {
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .register-card {
                padding: 25px;
            }
        }

        .password-input {
            padding-right: 40px;
        }

        .toggle-eye {
            position: absolute;
            right: 10px;
            bottom: 12px;
            cursor: pointer;
            font-size: 1.1rem;
            color: #555;
            z-index: 10;
        }

        .toggle-eye:hover {
            color: #0d6efd;
        }
    </style>
</head>

<body>

    <div class="register-card shadow">
        <h3 class="text-center mb-4 fw-bold">Registrasi Akun</h3>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="/register" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- kolom kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-semibold">Nama</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Masukkan Nama Lengkap">
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Alamat Usaha (Kost)</label>
                        <textarea name="alamat" class="form-control" required
                            placeholder="Masukkan Alamat Usaha Kost sertakan RT/RW"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Bukti KTP</label>
                        <input type="file" name="bukti_ktp" class="form-control" accept="image/*" required>
                    </div>
                </div>

                <!-- kolom kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control" required
                            placeholder="Masukkan Username">
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="fw-semibold">Password</label>

                        <input type="password" name="password" id="password"
                            class="form-control password-input"
                            placeholder="Masukkan Password" required>

                        <i class="bi bi-eye toggle-eye"
                            onclick="togglePassword('password', this)"></i>
                    </div>


                    <div class="mb-3 position-relative">
                        <label class="fw-semibold">Konfirmasi Password</label>

                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control password-input"
                            placeholder="Konfirmasi Password" required>

                        <i class="bi bi-eye toggle-eye"
                            onclick="togglePassword('password_confirmation', this)"></i>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-register mt-2">
                Daftar
            </button>
        </form>
        <p class="text-center mt-3 small">
            Sudah punya akun? <a href="/login">Login</a>
        </p>
    </div>
    <script>
        function togglePassword(id, icon) {
            const input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        }
    </script>



</body>

</html>