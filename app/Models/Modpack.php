<?php

namespace App\Models;

use App\Models\Traits\HasPrimaryKeyAsUuid;
use Illuminate\Bus\Batch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed manifest_last_update
 */
class Modpack extends Model
{
    use HasFactory;
    use HasPrimaryKeyAsUuid;

    protected $fillable = [
        'name',
        'game_id',
        'path',
        'disk',
        'job_batch_id',
        'manifest',
        'manifest_info',
        'manifest_last_update'
    ];

    protected $attributes = [
        'manifest' => '{}',
        'manifest_info' => '{"size": 0, "files": 0}'
    ];

    protected $casts = [
        'manifest' => 'array',
        'manifest_info' => 'array'
    ];

    protected $with = [
      'game'
    ];

    protected $appends = [
        'batch'
    ];

    protected static function booted()
    {
        static::created(function (Modpack $modPack) {
            if (!Storage::disk($modPack->disk)->exists($modPack->path)) {
                Storage::disk($modPack->disk)->makeDirectory($modPack->path);
            }
        });

        static::deleted(function (Modpack $modPack) {
            if (Storage::disk($modPack->disk)->exists($modPack->path)) {
                Storage::disk($modPack->disk)->deleteDirectory($modPack->path);
            }
        });
    }

    /**
     * @return BelongsToMany
     */
    public function servers(): BelongsToMany
    {
        return $this->belongsToMany(Server::class);
    }

    /**
     * @return BelongsTo
     */
    public function game(): BelongsTo
    {
      return $this->belongsTo(Game::class);
    }

    /**
     * @return Batch|null
     */
    public function getBatchAttribute(): ?Batch
    {
        if (!$this->job_batch_id) {
            return null;
        }
        return Bus::findBatch($this->job_batch_id);
    }

    /**
     * void
     */
    public function cleanManifest()
    {
        $this->update([
            'manifest' => [],
            'manifest_info' => [
                "size" => 0,
                "files" => 0
            ]
        ]);
    }
}
