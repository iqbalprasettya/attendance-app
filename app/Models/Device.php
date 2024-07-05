<?php

// app/Models/Device.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'device', 'device_name', 'device_brand', 'model', 'platform', 'os', 'browser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
