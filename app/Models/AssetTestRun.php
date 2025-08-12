<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetTestRun extends Model
{
    protected $fillable = [
        'asset_id',
        'user_id',
        'test_type',
        'status',
        'os_version',
        'notes',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'status' => 'string',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(AssetTestItem::class);
    }

    public function getAllPassedAttribute(): bool
    {
        return $this->items->where('status', 'fail')->count() === 0 && $this->items->count() > 0;
    }
}
