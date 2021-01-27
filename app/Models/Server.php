<?php

namespace App\Models;

use App\Models\Traits\HasLogo;
use App\Models\Traits\HasPrimaryKeyAsUuid;
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
    protected $appends = ['logo_url'];

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
    public function latestStatus()
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
}
