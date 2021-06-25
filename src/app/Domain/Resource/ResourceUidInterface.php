<?php declare(strict_types=1);

namespace App\Domain\Resource;

interface ResourceUidInterface
{
    public function uuid(): string;
}
