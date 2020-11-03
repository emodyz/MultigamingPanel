<?php

namespace App\Models;

use App\Models\Traits\HasPrimaryKeyAsUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
