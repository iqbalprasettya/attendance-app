<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DeviceDetector\DeviceDetector;

class AuthController extends Controller
{
    protected function detectDevice()
    {
        $dd = new DeviceDetector(request()->header('User-Agent'));
        $dd->parse();

        return [
            'device' => $dd->getDevice() ?: 'Unknown',
            'device_name' => $dd->getDeviceName() ?: 'Unknown',
            'device_brand' => $dd->getBrandName() ?: 'Unknown',
            'model' => $dd->getModel() ?: 'Unknown',
            'platform' => $dd->getOs('name') ?: 'Unknown',
            'os' => $dd->getOs('version') ?: 'Unknown',
            'browser' => $dd->getClient('name') ?: 'Unknown',
        ];
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:employee,admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $deviceData = $this->detectDevice();
        $user->devices()->create($deviceData);

        return redirect()->route('login')->with('message', 'Pendaftaran berhasil. Silakan login.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $deviceData = $this->detectDevice();

            $user = Auth::user();
            $existingDevice = $user->devices()->where('device', $deviceData['device'])
                ->where('device_name', $deviceData['device_name'])
                ->where('device_brand', $deviceData['device_brand'])
                ->where('model', $deviceData['model'])
                ->where('platform', $deviceData['platform'])
                ->where('os', $deviceData['os'])
                ->where('browser', $deviceData['browser'])
                ->first();

            if (!$existingDevice) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Perangkat tidak dikenali. Silakan daftar dari perangkat ini terlebih dahulu.',
                ])->withInput()->with('error', 'Login gagal. Perangkat tidak dikenali.');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->withInput()->with('error', 'Login gagal. Silakan periksa kredensial Anda dan coba lagi.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'Anda telah keluar.');
    }
}

