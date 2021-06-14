<?php declare(strict_types=1);

namespace App\ExternalAuthorization;
use App\ExternalAuthorization\Validators\Validator;

/**
 * Class ExternalValidator
 * @package App\ExternalAuthorization
 */
class ExternalValidator implements ExternalAuthorizationInterface
{
    /**
     * @param string $type
     * @param array $payload
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fire(string $type, array $payload): string
    {
        $type = $this->load($type, 'App\\ExternalAuthorization\\Validators');
        $payload = $type->body($payload);

        return $this->callSendApi($payload);
    }

    /**
     * @param $class
     * @param $namespace
     * @return mixed
     */
    private function load($class, $namespace): Validator
    {
        $class = ucfirst($class);
        $class = $namespace . "\\{$class}Validator";
        return new $class();
    }

    /**
     * @param array $message
     * @param string $method
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function callSendApi(array $message, $method = 'POST'): string
    {
        return (new CallSendApi())->make($message, $method);
    }
}
