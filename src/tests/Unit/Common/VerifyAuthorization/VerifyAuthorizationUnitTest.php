<?php declare(strict_types=1);

namespace Tests\Unit\Common\VerifyAuthorization;

use App\Common\VerifyAuthorization\VerifyAuthorization;
use App\Common\VerifyAuthorization\Exceptions\{NoGrantedException, ServiceOfflineException};
use Tests\Stubs\ExternalAuthorization\{ExternalValidatorErrorStub,ExternalValidatorOfflineStub,ExternalValidatorSuccessStub};
use Tests\TestCase;

/**
 * Class VerifyAuthorizationUnitTest
 * @package Tests\Unit\Common\VerifyAuthorization
 */
class VerifyAuthorizationUnitTest extends TestCase
{

    public function testInstance()
    {
        $onError = false;
        try {
            (new VerifyAuthorization(new ExternalValidatorSuccessStub()));
        }catch (\Exception $exception){
            $onError = true;
        }

        $this->assertFalse($onError);
    }

    public function testNoGrantedError()
    {
        $forceError = new ExternalValidatorErrorStub();
        $this->expectException(NoGrantedException::class);
        (new VerifyAuthorization($forceError))->grantAuthorization(['xpto']);

    }

    public function testGrantedServiceOffline()
    {

        $forceError = new ExternalValidatorOfflineStub();
        $this->expectException(ServiceOfflineException::class);
        (new VerifyAuthorization($forceError))->grantAuthorization(['xpto']);

    }


    public function testGrantedConfirmed() : void
    {
        $forceError = new ExternalValidatorSuccessStub();
        $result = (new VerifyAuthorization($forceError))->grantAuthorization(['xpto']);
        $this->assertTrue($result);
    }
}
