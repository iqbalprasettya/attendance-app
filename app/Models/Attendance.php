<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'check_in', 'check_out'];

    public function getTotalHoursAttribute()
    {
        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);
            $diff = $checkIn->diff($checkOut);

            return sprintf('%02d:%02d:%02d hrs', $diff->h, $diff->i, $diff->s);
        }
        return '00:00:00 hrs';
    }
}
