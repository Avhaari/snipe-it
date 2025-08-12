<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetTest extends Model
{
    protected $fillable = [
        'asset_id','user_id','component','result','comment','tested_at'
    ];

    public function asset()
    {
        return $this->belongsTo(\App\Models\Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
