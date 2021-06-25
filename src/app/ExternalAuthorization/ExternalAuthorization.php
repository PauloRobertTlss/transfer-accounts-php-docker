<?php declare(strict_types=1);

namespace App\ExternalAuthorization;
/**
 * Interface ExternalAuthorization
 * @package App\ExternalAuthorization
 */
interface ExternalAuthorization
{
    /**
     * @param string $type
     * @param array $payload
     * @return string
     */
    public function fire(string $type, array $payload): string;
}
