<?php

namespace App\Models;

use App\Models\Traits\HasPrimaryKeyAsUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\Pure;

/**
 * @property mixed logo_path
 * @property mixed ip
 * @property mixed name
 * @property mixed modpacks
 */
class Server extends Model
{
    use HasFactory;
    use HasPrimaryKeyAsUuid;

    protected $fillable = [
        'name',
        'ip',
        'port',
        'logo_path'
    ];

    protected $with = ['game'];

    /**
     * @return BelongsTo
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * @return string
     */
    public function host(): string
    {
        return "$this->ip:$this->port";
    }

    /**
     * @return HasMany
     */
    public function status(): HasMany
    {
        return $this->hasMany(ServerStatus::class);
    }

    /**
     * @return BelongsToMany
     */
    public function modpacks(): BelongsToMany
    {
        return $this->belongsToMany(Modpack::class);
    }

    /**
     * @return string
     */
    public function getUpdateHashAttribute(): string
    {
        $hash = "";
        $this->modpacks->each(function (Modpack $modpack) use (&$hash) {
            $hash .= $modpack->manifest_last_update;
        });
        return hash('sha256', $hash);
    }

    protected $appends = ['logo_url'];

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getLogoUrlAttribute(): string
    {
        return $this->logo_path
            ? Storage::disk('public')->url($this->logo_path)
            : $this->defaultLogoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    #[Pure] protected function defaultLogoUrl(): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }
}
