<?php declare(strict_types=1);

namespace Tests\Stubs\ExternalAuthorization;

use App\ExternalAuthorization\ExternalAuthorization as ExternalAuthorizationContract;

class ExternalValidatorSuccessStub implements ExternalAuthorizationContract
{

    public function fire(string $type, array $payload): string
    {
        echo "{$type}---------------------------stub authorized" .PHP_EOL;
        echo "\tsend payload: " . json_encode($payload) .PHP_EOL;
       return "success";
    }
}
