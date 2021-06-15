<?php declare(strict_types=1);

namespace Tests\Stubs\ExternalAuthorization;

use App\ExternalAuthorization\ExternalAuthorizationInterface;
use Mockery\Exception;

class ExternalValidatorErrorStub implements ExternalAuthorizationInterface
{
    public function fire(string $type, array $payload): string
    {
        throw new Exception('Ops! No authorized');
    }
}
