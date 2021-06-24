<?php declare(strict_types=1);

namespace Tests\Stubs\ExternalAuthorization;

use App\ExternalAuthorization\ExternalAuthorization as ExternalAuthorizationContract;
use Mockery\Exception;

class ExternalValidatorErrorStub implements ExternalAuthorizationContract
{
    public function fire(string $type, array $payload): string
    {
        throw new Exception('Ops! No authorized');
    }
}
