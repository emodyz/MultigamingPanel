<?php

namespace App\Models;

use App\Models\Traits\HasLogo;
use App\Models\Traits\HasPrimaryKeyAsUuid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed logo_path
 * @property mixed ip
 * @property mixed name
 * @property mixed modpacks
 * @property mixed articles
 * @property mixed port
 * @property mixed latest_status
 */
class Server extends Model
{
    use HasFactory;
    use HasPrimaryKeyAsUuid;
    use HasLogo;
    use SoftDeletes;

    protected string $logoDiskPath = 'servers';

    protected $fillable = [
        'name',
        'ip',
        'port',
        'logo_path'
    ];

    protected $with = ['game'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
      'logo_url',
      'latest_status'
    ];
    /**
     * @var mixed
     */

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
     * @return ServerStatus|Model|HasMany|object
     */
    public function getLatestStatusAttribute()
    {
        return $this->status()->latest()->first();
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
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)->withTimestamps();
    }

    /**
     * Returns a list of all the servers that are currently online
     *
     * @return Collection
     */
    public static function online(): Collection
    {
        return self::with(['status' => function ($query) {
            $query
                ->where('online', true)
                ->latest()
                ->first();
        }])
            ->get()
            ->filter(fn($server, $key) => $server->latest_status->online === true);
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
}
