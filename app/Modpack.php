<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modpack
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $manifest
 * @property string $manifest_last_update
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Server[] $servers
 * @property-read int|null $servers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack whereManifest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack whereManifestLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modpack whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Modpack extends Model
{
    protected $fillable = [
        'name',
        'path',
        'manifest',
        'manifest_last_update'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function servers()
    {
        return $this->belongsToMany(Server::class);
    }
}
