    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\AttendanceController;

    // ===== AUTH =====
    Route::middleware('guest')->group(function () {
        Route::get('/', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [AuthController::class, 'register']);
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // ===== ATTENDANCE =====
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AttendanceController::class, 'index'])->name('dashboard');
        Route::post('/attendances/toggle', [AttendanceController::class, 'toggleAttendance'])->name('attendances.toggle');
    });
