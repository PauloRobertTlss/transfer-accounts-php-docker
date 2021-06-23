<?php declare(strict_types=1);

namespace Tests\Unit\Common\ManageRule;

use App\Common\ManageRule\Exceptions\NoClassRuleException;
use App\Common\ManageRule\ManageRules;
use App\Common\ManageRule\ManageRulesInterface;
use App\Common\ManageRule\Types\NoAllowedShopkeeperRule;
use App\Domain\CRM\Client\Entity\ClientInterface;
use Illuminate\Support\Facades\Log;

//use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Tests\Stubs\ExternalAuthorization\ExternalValidatorSuccessStub;
use Tests\TestCase;
use Tests\Traits\TestInstance;

class ManageRulesUnitTest extends TestCase
{
    use TestInstance;

    /**
     * @var ManageRules
     */
    private ManageRules $instance;

    protected function setUp(): void
    {
        parent::setUp();
        $this->instance = new ManageRules();
        $this->logger = $this->getMockBuilder(LoggerInterface::class)
            ->setMethods([
                'emergency',
                'alert',
                'critical',
                'error',
                'warning',
                'notice',
                'info',
                'debug',
                'log'
            ])
            ->getMock();
    }

    public function namespace(): string
    {
        return ManageRules::class;
    }

    public function testInstance(): void
    {
        $this->assertInstance();
    }

    public function testObjectType(): void
    {
        $this->assertInstanceOf(ManageRulesInterface::class, $this->instance);
    }

    public function testHasMethods(): void
    {
        $this->assertTrue(method_exists($this->instance, 'resetRules'));
    }

    public function testGetTypeErrorException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->instance->pushRule(1111);
    }

    public function testRulesFieldStartedEmpty(): void
    {
        $reflectionClass = new \ReflectionClass(ManageRules::class);
        $reflectionProperty = $reflectionClass->getProperty('rules');
        $reflectionProperty->setAccessible(true);

        $rules = $reflectionProperty->getValue($this->instance);
        $this->assertEmpty($rules);

    }

    public function testPushStringWithoutNamespace(): void
    {
        $uuid = Uuid::uuid4()->toString();
        $this->expectExceptionMessage("Class '{$uuid}' not found");
        $this->instance->pushRule($uuid);
    }

    public function testPushObjectNoRule(): void
    {

//      Log::shouldReceive('error');
        $this->expectException(NoClassRuleException::class);
        $this->instance->pushRule(new ExternalValidatorSuccessStub());

    }

    public function testRulesField(): void
    {
        $reflectionClass = new \ReflectionClass(ManageRules::class);
        $reflectionProperty = $reflectionClass->getProperty('rules');
        $reflectionProperty->setAccessible(true);

        $this->instance->pushRule(new NoAllowedShopkeeperRule());
        $rules = $reflectionProperty->getValue($this->instance);
        $this->assertNotEmpty($rules);
    }

    public function testParseRulesOneClient(): void
    {
        $onError = false;
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();

        $this->instance->pushRule(new NoAllowedShopkeeperRule());
        try {
            $this->instance->parseRules($client);
        } catch (\Exception $exception) {
            $onError = true;
        }

        $this->assertFalse($onError);

    }


}
