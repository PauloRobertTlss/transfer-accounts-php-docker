<?php declare(strict_types=1);

namespace App\ExternalAuthorization\Validators;

final class TransactionValidator implements Validator
{
    /**
     * @param array $payload
     * @return array
     */
    public function body(array $payload): array
    {
        return [
            'type' => 'check_please',
            'payload' => $payload
        ];
    }
}
