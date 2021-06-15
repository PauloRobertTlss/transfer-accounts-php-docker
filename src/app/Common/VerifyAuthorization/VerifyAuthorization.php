<?php declare(strict_types=1);

namespace App\Common\VerifyAuthorization;

use App\Domain\Financial\Transaction\Service\VerifyAuthorizationInterface;
use App\ExternalAuthorization\ExternalAuthorizationInterface;
use GuzzleHttp\Exception\ClientException;
use App\Common\VerifyAuthorization\Exceptions\{NoGrantedException, ServiceOfflineException};
use Illuminate\Support\Facades\Log;

/**
 * Class VerifyAuthorization
 * @package App\Common\VerifyAuthorization
 */
class VerifyAuthorization implements VerifyAuthorizationInterface
{
    public const EXTERNAL_VALIDATOR = 'transaction';
    /**
     * @var ExternalAuthorizationInterface
     */
    private ExternalAuthorizationInterface $serviceAuthorization;

    /**
     * VerifyAuthorization constructor.
     * @param ExternalAuthorizationInterface $serviceAuthorization
     */
    public function __construct(ExternalAuthorizationInterface $serviceAuthorization)
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
                throw new ServiceOfflineException('Ops! Offline service grant');
            }
        }

        Log::info('Ops! Service grant ' . env('APP_NAME') . ' not allowed');

        throw new NoGrantedException('Ops! Transaction no granted');

    }
}
