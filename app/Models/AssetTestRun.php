<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Statuslabel;

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

    protected static function booted()
    {
        static::saved(function (self $run) {
            if (
                $run->status === 'completed' &&
                $run->all_passed &&
                config('test-runs.auto_complete')
            ) {
                $statusId = Statuslabel::where('name', 'Ready to Deploy')->value('id');
                if ($statusId) {
                    $asset = $run->asset;
                    $asset->status_id = $statusId;
                    $asset->save();
                }
            }
        });
    }

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
