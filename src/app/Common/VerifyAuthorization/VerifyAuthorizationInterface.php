<?php declare(strict_types=1);

namespace App\Common\VerifyAuthorization;

interface VerifyAuthorizationInterface
{
    /**
     * @param array $args
     * @return bool
     */
    public function grantAuthorization(array $args): bool;

}
