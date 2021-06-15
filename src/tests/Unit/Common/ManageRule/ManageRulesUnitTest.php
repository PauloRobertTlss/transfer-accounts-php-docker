<?php declare(strict_types=1);

namespace Tests\Unit\Common\ManageRule;

use App\Common\ManageRule\Exceptions\NoClassRuleException;
use App\Common\ManageRule\ManageRules;
use App\Common\ManageRule\ManageRulesInterface;
use App\Common\ManageRule\Types\NoAllowedShopkeeperRule;
use App\Domain\CRM\Client\Entity\ClientInterface;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
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
    }


    public function namespace(): string
    {
        return ManageRules::class;
    }

    public function testInstance(): void
    {
        $this->assertInstance();
    }

    public function testObjectType()
    {
        $this->assertInstanceOf(ManageRulesInterface::class, $this->instance);
    }

    public function testHasMethods()
    {
        $this->assertTrue(method_exists($this->instance, 'resetRules'));
    }

    public function testGetTypeErrorException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->instance->pushRule(1111);
    }

    public function testRulesFieldStartedEmpty()
    {
        $reflectionClass = new \ReflectionClass(ManageRules::class);
        $reflectionProperty = $reflectionClass->getProperty('rules');
        $reflectionProperty->setAccessible(true);

        $rules = $reflectionProperty->getValue($this->instance);
        $this->assertEmpty($rules);

    }

    public function testPushStringWithoutNamespace()
    {
        $uuid = Uuid::uuid4()->toString();
        $this->expectExceptionMessage("Class '{$uuid}' not found");
        $this->instance->pushRule($uuid);
    }

    public function testPushObjectNoRule()
    {
        Log::shouldReceive('error')->andReturnSelf();
        $this->expectException(NoClassRuleException::class);
        $this->instance->pushRule(new \Mockery());
    }

    public function testRulesField()
    {
        $reflectionClass = new \ReflectionClass(ManageRules::class);
        $reflectionProperty = $reflectionClass->getProperty('rules');
        $reflectionProperty->setAccessible(true);

        $this->instance->pushRule(new NoAllowedShopkeeperRule());
        $rules = $reflectionProperty->getValue($this->instance);
        $this->assertNotEmpty($rules);
    }

    public function testParseRulesOneClient()
    {
        $onError = false;
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $this->instance->pushRule(new NoAllowedShopkeeperRule());
        try {
            $this->instance->parseRules($client);
        }catch (\Exception $exception) {
            $onError = true;
        }

        $this->assertFalse($onError);



    }


}
