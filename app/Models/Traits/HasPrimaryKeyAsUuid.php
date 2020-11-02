<?php


namespace App\Models\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

trait HasPrimaryKeyAsUuid
{

    public static function bootHasPrimaryKeyAsUuid()
    {
        static::creating(function ($model) {
            $model->id = Uuid::uuid4();
        });

        static::saving(function ($model) {
            $original_uuid = $model->getOriginal('id');

            if ($original_uuid !== $model->id) {
                $model->id = $original_uuid;
            }
        });
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
