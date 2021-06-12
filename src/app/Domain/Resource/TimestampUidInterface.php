<?php declare(strict_types=1);

namespace App\Domain\Resource;

use Illuminate\Support\Carbon;

interface TimestampUidInterface extends ResourceUidInterface
{
    public function createdAt(): Carbon;
}
