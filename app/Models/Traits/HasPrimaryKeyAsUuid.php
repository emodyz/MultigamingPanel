<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

trait HasPrimaryKeyAsUuid
{

    public static function bootHasPrimaryKeyAsUuid()
    {
        static::creating(function (Model $model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::saving(function (Model $model) {
            $originalKey = $model->getOriginal($model->getKeyName());
            if (!is_null($originalKey)) {
                if ($originalKey !== $model->{$model->getKeyName()}) {
                    $model->{$model->getKeyName()} = $originalKey;
                }
            }
        });
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    public function getIncrementing(): bool
    {
        return false;
    }
}
