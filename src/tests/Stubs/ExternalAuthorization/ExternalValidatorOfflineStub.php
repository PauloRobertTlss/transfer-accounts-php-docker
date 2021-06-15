<?php declare(strict_types=1);

namespace Tests\Stubs\ExternalAuthorization;

use App\ExternalAuthorization\ExternalAuthorizationInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery\Exception;

class ExternalValidatorOfflineStub implements ExternalAuthorizationInterface
{
    public function fire(string $type, array $payload): string
    {
        echo "Guzzle". PHP_EOL;
        throw new ClientException('Client offline', new Request('PUT','wwww'), new Response());
    }
}
