<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpeedTestHistory extends Model
{
    protected $fillable = ['user_id', 'download_speed', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
