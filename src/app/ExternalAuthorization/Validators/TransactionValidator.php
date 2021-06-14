<?php declare(strict_types=1);

namespace App\ExternalAuthorization\Validators;

class TransactionValidator implements Validator
{
    /**
     * @param array $payload
     * @return array
     */
    public function body(array $payload)
    {
        return [
            'type' => 'check_please',
            'payload' => $payload
        ];
    }
}
