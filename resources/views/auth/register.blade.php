<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            /* width: 250px; */
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
            <div class="col-md-6">
                <div class="card p-4 m-3 shadow-sm">
                    <div class="header-text text-center mb-3">
                      <h5 class="fw-bold">Daftar</h5>  <p class="text-muted">Silahkan Daftar untuk memproses presentasi Anda</p>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                      @csrf
                  
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label for="name" class="form-label fw-semibold">Nama</label>  <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nama Anda" required>
                        </div>
                  
                        <div class="col-md-6">
                          <label for="email" class="form-label fw-semibold">Alamat Email</label>  <input type="email" class="form-control" id="email" name="email"
                            placeholder="Email Anda" required>
                        </div>
                      </div>
                  
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label for="password" class="form-label fw-semibold">Kata Sandi</label>  <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                              placeholder="Kata Sandi Anda" required>
                            <button class="btn btn-light" type="button" id="showPasswordToggle">
                              <i class="bi bi-eye"></i>
                            </button>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi</label>  <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation"
                              name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
                            <button class="btn btn-light" type="button" id="showPasswordConfirmationToggle">
                              <i class="bi bi-eye"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                  
                      <div class="mb-3 visually-hidden">
                        <label for="role" class="form-label">Peran</label>  <select class="form-control" id="role" name="role" required>
                          <option value="employee">Karyawan</option>  <option value="admin">Admin</option>
                        </select>
                      </div>
                  
                      <button type="submit" class="btn-custom">Daftar</button>
                    </form>
                    <div class="footer-card text-center mt-3">
                      Sudah punya akun? <a href="{{ route('login') }}" class="text-danger">Login</a>
                    </div>
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

            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const showPasswordConfirmationToggle = document.getElementById('showPasswordConfirmationToggle');

            showPasswordToggle.addEventListener('click', function() {
                togglePasswordVisibility(passwordInput, showPasswordToggle);
            });

            showPasswordConfirmationToggle.addEventListener('click', function() {
                togglePasswordVisibility(passwordConfirmationInput, showPasswordConfirmationToggle);
            });

            function togglePasswordVisibility(inputField, toggleButton) {
                if (inputField.type === 'password') {
                    inputField.type = 'text';
                    toggleButton.innerHTML = '<i class="bi bi-eye-slash"></i>';
                } else {
                    inputField.type = 'password';
                    toggleButton.innerHTML = '<i class="bi bi-eye"></i>';
                }
            }
        });

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>'
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
