<?php declare(strict_types=1);

namespace App\Domain\Resource;

interface ResourceId
{
    public function id(): int;
}
