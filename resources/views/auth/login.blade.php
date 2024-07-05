<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: rgb(201, 13, 14);
            background: linear-gradient(137deg,
                    rgba(201, 13, 14, 1) 0%,
                    rgba(246, 139, 9, 1) 100%);
            height: 100vh;
        }

        .header-text {
            margin-right: auto;
            margin-left: auto;
        }

        .btn-custom {
            background-color: rgba(201, 13, 14, 1);
            color: #fff;
            border: none;
            border-radius: 9px;
            width: 100%;
            padding: 10px 0;
        }

        input {
            font-size: 11pt !important;
        }

        label {
            font-size: 11pt;
        }

        .footer-card {
            font-size: 11pt
        }
    </style>
</head>

<body>
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card px-4 py-5 m-3 shadow-sm">
                    <div class="header-text text-center mb-3">
                        <h5 class="fw-bold">Selamat Datang Kembali</h5>
                        <p class="text-muted">Silahkan Login untuk memproses presentasi Anda</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label> <input type="email"
                                class="form-control" id="email" name="email" placeholder="Email Anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Kata Sandi Anda" required>
                                <button class="btn btn-light" type="button" id="showPasswordToggle">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn-custom">Login</button>
                    </form>
                    <div class="footer-card text-center mt-3">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-danger">Daftar</a>
                    </div>
                </div>

            </div>
        </div>

        <script src="https://cd.jsdelivrn.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const passwordInput = document.getElementById('password');
                const showPasswordToggle = document.getElementById('showPasswordToggle');

                showPasswordToggle.addEventListener('click', function() {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        showPasswordToggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
                    } else {
                        passwordInput.type = 'password';
                        showPasswordToggle.innerHTML = '<i class="bi bi-eye"></i>';
                    }
                });
            });

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}'
                });
            @endif

            @if (session('message'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('message') }}'
                });
            @endif
        </script>

</body>

</html>
