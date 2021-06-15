<?php declare(strict_types=1);

namespace Tests\Stubs\Common\Repositories;

use App\Common\Repositories\BaseRepository;

class BaseRepositoryStub extends BaseRepository
{

    public function model(): string
    {
        return ModelStub::class;
    }
}
