<?php declare(strict_types=1);

namespace App\ExternalAuthorization;
/**
 * Interface ExternalAuthorizationInterface
 * @package App\ExternalAuthorization
 */
interface ExternalAuthorizationInterface
{
    /**
     * @param string $type
     * @param array $payload
     * @return string
     */
    public function fire(string $type, array $payload): string;
}
