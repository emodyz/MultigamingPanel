<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Server
 *
 * @property int $id
 * @property string $name
 * @property string $ip
 * @property int $port
 * @property string $picture
 * @property array|null $data
 * @property array|null $modpacks
 * @property int $game_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Game|null $game
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereModpacks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Server whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $modpacks_count
 */
class Server extends Model
{
    protected $fillable = [
        'name',
        'ip',
        'port',
        'picture',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'modpacks' => 'array'
    ];

    /**
     * @return HasOne
     */
    public function game(): HasOne {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modpacks()
    {
        return $this->belongsToMany(Modpack::class);
    }
}
