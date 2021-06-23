<?php declare(strict_types=1);

namespace Tests\Unit\Common\ManageRule\Types;

use App\Common\ManageRule\Contract\RuleInterface;
use App\Common\ManageRule\Exceptions\NoAllowedShopKeeperRuleException;
use App\Common\ManageRule\Types\NoAllowedShopkeeperRule;
use App\Domain\CRM\Client\Entity\ClientInterface;
use Illuminate\Support\Facades\Log;
//use PHPUnit\Framework\TestCase;
use Tests\Stubs\Domain\CRM\Client\Entity\PersonStub;
use Tests\Stubs\Domain\CRM\Client\Entity\ShopkeeperStub;
use Tests\TestCase;

class NoAllowedShopkeeperRuleUnitTest extends TestCase
{
    /**
     * @var NoAllowedShopkeeperRule
     */
    private NoAllowedShopkeeperRule $instance;

    protected function setUp(): void
    {
        parent::setUp();
        $this->instance = new NoAllowedShopkeeperRule();
    }

    public function testObjectType()
    {
        $this->assertInstanceOf(RuleInterface::class, $this->instance);
    }


    public function testParseOrFailShopkeeper(): void
    {
//        $client = \Mockery::mock(ClientInterface::class);
//        $client
//            ->shouldReceive('getDocument')
//            ->once()
//            ->andReturn(new ShopkeeperStub())->getMock();

        $client = $this->getMockBuilder(ClientInterface::class)
            ->disableOriginalConstructor() // This is necessary in actual program
            ->getMock();
        $client->expects($this->once())
            ->method('getDocument')
            ->willReturn(new ShopkeeperStub());

//        Log::shouldReceive('error')->andReturnSelf();
        $this->expectException(NoAllowedShopKeeperRuleException::class);
        $response = $this->instance->parseOrFail($client);
        $this->assertTrue($response);

    }

    public function testParseOrFailPerson(): void
    {
        $client = $this->getMockBuilder(ClientInterface::class)
            ->disableOriginalConstructor() // This is necessary in actual program
            ->getMock();
        $client->expects($this->once())
            ->method('getDocument')
            ->willReturn(new PersonStub());

//        $client = \Mockery::mock(ClientInterface::class);
//        $client
//            ->shouldReceive('getDocument')
//            ->once()
//            ->andReturn(new PersonStub());
//
//        Log::shouldReceive('error')->withAnyArgs()->andReturnSelf();
        $response = $this->instance->parseOrFail($client);
        $this->assertTrue($response);

    }
}
