<?php declare(strict_types=1);

namespace App\ExternalAuthorization\Build;

use App\ExternalAuthorization\{ExternalAuthorizationInterface, ExternalValidator};

/**
 * Class Singleton
 * @package App\ExternalAuthorization\Build
 */
class Singleton
{
    /**
     * @var ExternalAuthorizationInterface|null
     */
    private static ?ExternalAuthorizationInterface $instance;

    private function __construct()
    {
        // Do nothing
    }

    private function __clone()
    {
        // Do nothing
    }

    public static function instance(): ?ExternalAuthorizationInterface
    {
        if (self::$instance === null) {
            self::$instance = new ExternalValidator();
        }
        return self::$instance;
    }

    public static function __callStatic($name, $arguments)
    {
        call_user_func_array([self::$instance, $name], $arguments);
    }
}
