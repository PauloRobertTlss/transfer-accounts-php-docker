<?php declare(strict_types=1);

namespace App\ExternalAuthorization\Validators;
/**
 * Interface Validator
 * @package App\ExternalAuthorization\Validators
 */
interface Validator
{
    /**
     * @param array $payload
     * @return array
     */
    public function body(array $payload): array;
}
