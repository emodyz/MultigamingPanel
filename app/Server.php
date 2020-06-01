<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Server extends Model
{
    protected $fillable = [
        'name',
        'ip',
        'port',
        'picture',
        'data',
        'modpacks'
    ];

    protected $casts = [
        'data' => 'array',
        'modpacks' => 'array'
    ];

    public function game(): HasOne {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }
}
