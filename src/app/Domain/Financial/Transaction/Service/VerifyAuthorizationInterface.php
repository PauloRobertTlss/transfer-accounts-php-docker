<?php declare(strict_types=1);

namespace App\Domain\Financial\Transaction\Service;

interface VerifyAuthorizationInterface
{
    public function grantAuthorization(array $args): bool;

}
