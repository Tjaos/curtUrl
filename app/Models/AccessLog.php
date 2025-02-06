<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $fillable = ['url_id', 'ip_address', 'accessed_at'];

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
