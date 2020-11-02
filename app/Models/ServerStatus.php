<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerStatus extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'server_id',
        'online',
        'players_max',
        'players_online'
    ];

    protected $casts = [
        'online' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * @return BelongsTo
     */
    public function game(): BelongsTo
    {
        return $this->server()->game();
    }
}
