<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetTestItem extends Model
{
    public const COMPONENTS = [
        'keyboard',
        'screen',
        'touchpad',
        'usb',
        'sd',
        'dvd',
        'vga',
        'hdmi',
        'cpu_stress',
        'battery',
        'ram',
        'webcam',
        'mic',
        'speakers',
        'wifi',
        'bluetooth',
        'ethernet',
        'fingerprint',
    ];

    protected $fillable = [
        'asset_test_run_id',
        'component',
        'status',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function run(): BelongsTo
    {
        return $this->belongsTo(AssetTestRun::class, 'asset_test_run_id');
    }
}
