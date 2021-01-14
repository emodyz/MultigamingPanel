<?php

namespace App\Models;

use App\Models\Traits\HasCoverImage;
use App\Models\Traits\HasPrimaryKeyAsUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed servers
 */
class Article extends Model
{
    use HasFactory;
    use HasPrimaryKeyAsUuid;
    use HasCoverImage;
    use SoftDeletes;

    protected string $coverImageDiskPath = 'articles';

    protected $appends = ['cover_image_url'];

    protected $with = ['author'];

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function servers(): BelongsToMany
    {
        return $this->belongsToMany(Server::class)->withTimestamps();
    }

    public static function getAllGlobalArticles()
    {
        return self::where('status', 'published')->latest()->get();
    }

    public static function getLastGlobalArticles($n = 1)
    {
        return self::where('status', 'published')->latest()->take($n)->get();
    }
}
