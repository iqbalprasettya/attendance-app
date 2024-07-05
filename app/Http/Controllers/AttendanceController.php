<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DeviceDetector\DeviceDetector;

class AttendanceController extends Controller
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

    protected function checkDevice()
    {
        $deviceData = $this->detectDevice();
        $user = Auth::user();
        return $user->devices()->where('device', $deviceData['device'])
            ->where('device_name', $deviceData['device_name'])
            ->where('device_brand', $deviceData['device_brand'])
            ->where('model', $deviceData['model'])
            ->where('platform', $deviceData['platform'])
            ->where('os', $deviceData['os'])
            ->where('browser', $deviceData['browser'])
            ->exists();
    }

    public function index()
    {
        if (!$this->checkDevice()) {
            return redirect()->route('dashboard')->with('error', 'Perangkat tidak dikenali.');
        }

        $todayAttendance = Attendance::where('user_id', Auth::id())
            ->where('date', now()->toDateString())
            ->first();

        $attendances = Attendance::where('user_id', Auth::id())->orderBy('date', 'desc')->get();

        // total current time
        $currentWorkTime = null;
        if ($todayAttendance && $todayAttendance->check_in !== null) {
            $now = Carbon::now();
            if ($todayAttendance->check_out === null) {
                $diffInSeconds = $now->diffInSeconds(Carbon::parse($todayAttendance->check_in));
                $currentWorkTime = gmdate('H:i:s', $diffInSeconds);
            } else {
                $diffInSeconds = Carbon::parse($todayAttendance->check_out)->diffInSeconds(Carbon::parse($todayAttendance->check_in));
                $currentWorkTime = gmdate('H:i:s', $diffInSeconds);
            }
        }

        return view('attendances.index', compact('attendances', 'todayAttendance', 'currentWorkTime'));
    }

    public function toggleAttendance()
    {
        if (!$this->checkDevice()) {
            return redirect()->route('dashboard')->with('error', 'Perangkat tidak dikenali.');
        }

        $today = now()->toDateString();
        $now = now();
        $hour = $now->hour;

        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', $today)
            ->first();

        if ($attendance) {
            // Check-out logic
            if ($attendance->check_out === null) {
                $attendance->update(['check_out' => $now->toTimeString()]);
                return redirect()->route('dashboard')->with('message', 'Berhasil check-out.');
            } else {
                return redirect()->route('dashboard')->with('error', 'Anda sudah melakukan check-out hari ini.');
            }
        } else {
            // Check-in logic
            if ($hour >= 7 && $hour < 17) {
                Attendance::create([
                    'user_id' => Auth::id(),
                    'date' => $today,
                    'check_in' => $now->toTimeString(),
                ]);
                return redirect()->route('dashboard')->with('message', 'Berhasil check-in.');
            } else {
                return redirect()->route('dashboard')->with('error', 'Check-in hanya diizinkan antara pukul 07:00 dan 17:00.');
            }
        }
    }
}
