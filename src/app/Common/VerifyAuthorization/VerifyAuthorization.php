<?php declare(strict_types=1);

namespace App\Common\VerifyAuthorization;

use App\Common\VerifyAuthorization\Exceptions\{NoGranted, ServiceOffline};
use App\ExternalAuthorization\ExternalAuthorization;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

/**
 * Class VerifyAuthorization
 * @package App\Common\VerifyAuthorization
 */
final class VerifyAuthorization implements VerifyAuthorizationInterface
{
    public const EXTERNAL_VALIDATOR = 'transaction';
    /**
     * @var ExternalAuthorization
     */
    private ExternalAuthorization $serviceAuthorization;

    /**
     * VerifyAuthorization constructor.
     * @param ExternalAuthorization $serviceAuthorization
     */
    public function __construct(ExternalAuthorization $serviceAuthorization)
    {
        $this->serviceAuthorization = $serviceAuthorization;
    }

    public function grantAuthorization(array $args): bool
    {
        try {

            if ($this->serviceAuthorization->fire(self::EXTERNAL_VALIDATOR, $args)) {
                return true;
            }

        } catch (\Exception $exception) {

            Log::error('Ops! Service grant ' . env('APP_NAME') . ' offline', debug_backtrace(3));
            if ($exception instanceof ClientException) {
                throw new ServiceOffline('Ops! Offline service grant');
            }
        }

        Log::info('Ops! Service grant ' . env('APP_NAME') . ' not allowed');

        throw new NoGranted('Ops! Transaction no granted');

    }
}
