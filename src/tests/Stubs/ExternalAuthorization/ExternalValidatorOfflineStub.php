<?php declare(strict_types=1);

namespace Tests\Stubs\ExternalAuthorization;

use App\ExternalAuthorization\ExternalAuthorization as ExternalAuthorizationContract;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class ExternalValidatorOfflineStub implements ExternalAuthorizationContract
{
    public function fire(string $type, array $payload): string
    {
        echo "Guzzle". PHP_EOL;
        throw new ClientException('Client offline', new Request('PUT','wwww'), new Response());
    }
}
