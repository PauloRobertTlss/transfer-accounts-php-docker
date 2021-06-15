<?php declare(strict_types=1);

namespace Tests\Stubs\Common\Repositories;

use Illuminate\Database\Eloquent\Model;

class ModelStub extends Model
{

    public function newInstance($attributes = [], $exists = false)
    {
        return new static();
    }

    public function save(array $options = [])
    {
        return true;
    }
}
