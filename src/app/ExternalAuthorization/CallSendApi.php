<?php declare(strict_types=1);

namespace App\ExternalAuthorization;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

/**
 * Class CallSendApi
 * @package App\ExternalAuthorization
 */
class CallSendApi
{
    public const URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    /**
     * @param array $body
     * @param string $method
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function make(array $body, $method = 'POST'): string
    {
        $client = new Client(['headers' => ['Content-Type' => 'application/json']]);
        $url = self::URL;

        $payload = json_encode($body, 0, 512);

        $response = $client->request($method, $url, ['body' => $payload]);
        Log::info("success [authorization] [" . $response->getBody()->getContents() . "]");
        return $response->getBody()->getContents();
    }

}
