<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- custom css --}}
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="attendance-header px-3 text-white">
        <div class="header-text d-flex justify-content-between">
            <div class="text">
                <h2>{{ Auth::user()->name }}</h2>
                <h5>
                    {{-- {{ Auth::user()->role }} buat ketika employee tampilkan Staff jika admin tampilkan Admin --}}
                    {{ Auth::user()->role == 'admin' ? 'Admin' : 'Staff' }}
                </h5>
            </div>
            <div class="icon">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="bi bi-box-arrow-right"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="card px-3 py-4 shadow-sm">
            <div class="d-flex justify-content-between align-middle">
                <div class="jadwal-text">
                    <p>Jadwal Hari ini</p>
                </div>
                <div class="jadwal-tanggal">
                    <p>{{ \Carbon\Carbon::now()->translatedFormat('D d, M Y') }} <i class="bi bi-calendar-check"></i>
                    </p>
                </div>
            </div>
            <div class="text-center mt-4">
                <h3 class="mb-3"><span class="fw-bold">08.00</span> ••• <span class="fw-bold">17.00</span></h3>
                <form id="attendance-form" method="POST" action="{{ route('attendances.toggle') }}">
                    @csrf
                    <button type="button" class="btn-custom px-5 py-1"
                        @if (isset($todayAttendance) && $todayAttendance->check_in !== null && $todayAttendance->check_out !== null) disabled @endif onclick="confirmAttendance()">
                        @if (isset($todayAttendance) && $todayAttendance->check_out !== null)
                            Absen Selesai!
                        @elseif (isset($todayAttendance) && $todayAttendance->check_in !== null)
                            Absen Keluar
                        @else
                            Absen Masuk
                        @endif
                    </button>
                </form>

            </div>
        </div>
    </div>

    <div class="attendance-history">
        <div class="count-time card p-3 m-2 shadow-sm">
            <div class="d-flex justify-content-between">
                <div class="time d-flex">
                    <div class="dot-container">
                        <div class="dot-back"></div>
                        <div class="dot-front"></div>
                    </div>
                    <div class="text">
                        <p class="text-time mb-0">Waktu Kerja Saat Ini</p>
                    </div>
                </div>
                <div class="work-status d-flex">
                    
                    <div class="work">
                        <p class="mb-0">Work</p>
                    </div>
                </div>
            </div>
            <div class="time-total">
                <h5 class="mt-1 fw-semibold">
                    @if ($currentWorkTime)
                        {{ $currentWorkTime }}
                    @else
                        00:00:00 hrs
                    @endif
                </h5>
            </div>
        </div>

        <div class="p-2">
            <h4 class="mt-4">Riwayat Kehadiran</h4>
        </div>

        @if ($attendances->isEmpty())
            <div class="card p-2 m-2 mt-0 shadow-sm">
                <p>Tidak ada catatan kehadiran.</p>
            </div>
        @else
            @foreach ($attendances as $attendance)
                <div class="card p-2 m-2 mt-0 shadow-sm">
                    <div class="d-flex justify-content-between align-middle">
                        <div class="jadwal-tanggal">
                            <p>{{ \Carbon\Carbon::now()->translatedFormat('D d, M Y') }} <i
                                    class="bi bi-calendar-check"></i></p>
                        </div>
                    </div>
                    <div class="text-card d-flex justify-content-between mt-3">
                        <p>Total Jam</p>
                        <p>Masuk & Keluar</p>
                    </div>
                    <div class="text-card d-flex justify-content-between">
                        <p class="fw-bold">{{ $attendance->total_hours }}</p>
                        <div class="d-flex fw-semibold">
                            <p>{{ $attendance->check_in }} - {{ $attendance->check_out }}</p>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Bottom Navigation -->
    <nav class="nav-bottom navbar-light fixed-bottom">
        <div class="container d-flex justify-content-around bg-light">
            <a href="{{ route('dashboard') }}" class="nav-item nav-link active">
                <i class="bi bi-house-door-fill"></i>
                <span class="d-block">Beranda</span>
            </a>
            <a href="{{ route('dashboard') }}" class="nav-item nav-link">
                <i class="bi bi-calendar-check-fill"></i>
                <span class="d-block">Jadwal</span>
            </a>
            <a href="#" class="nav-item nav-link">
                <i class="bi bi-person-fill"></i>
                <span class="d-block">Profil</span>
            </a>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        @if (session('message'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('message') }}',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: '{{ session('error') }}',
            });
        @endif

        function confirmAttendance() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan melakukan absen masuk/keluar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, absen!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('attendance-form').submit();
                }
            });
        }
    </script>
</body>

</html>
