<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['long_url', 'short_url', 'expires_at', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }
}
