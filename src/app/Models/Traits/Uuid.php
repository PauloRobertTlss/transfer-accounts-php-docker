<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid as BaseUuid;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($obj) {
            if (empty($obj->id)) {
                $obj->id = BaseUuid::uuid4();
            }
        });
    }
}
