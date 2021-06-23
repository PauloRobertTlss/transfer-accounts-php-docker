<?php declare(strict_types=1);

namespace Tests\Unit\Common\ManageRule\Types;

use App\Common\ManageRule\Contract\RuleInterface;
use App\Common\ManageRule\Exceptions\WithoutBalanceRuleException;
use App\Common\ManageRule\Types\BalanceNoZeroRule;
use App\Domain\CRM\Client\Entity\ClientInterface;
use App\Domain\Financial\BankAccount\Entity\Contract\BankAccountInterface;
use PHPUnit\Framework\TestCase;

class BalanceNoZeroRuleUnitTest extends TestCase
{
    public const VALUE = 999;
    /**
     * @var BalanceNoZeroRule
     */
    private BalanceNoZeroRule $instance;

    protected function setUp(): void
    {
        parent::setUp();
        $this->instance = new BalanceNoZeroRule(self::VALUE);
    }

    public function testObjectType()
    {
        $this->assertInstanceOf(RuleInterface::class, $this->instance);
    }

    public function testRulesFieldStartedEmpty()
    {
        $reflectionClass = new \ReflectionClass(BalanceNoZeroRule::class);
        $reflectionProperty = $reflectionClass->getProperty('value');
        $reflectionProperty->setAccessible(true);
        $value = $reflectionProperty->getValue($this->instance);
        $this->assertEquals($value,self::VALUE);

    }


    public function testParseOrFailEnoughBalance()
    {
        $bankAccount = $this->getMockBuilder(BankAccountInterface::class)
            ->onlyMethods(['getBalance','getAgency','getAccount','getClient','id'])
            ->getMock();

        $client = $this->getMockBuilder(ClientInterface::class)
            ->disableOriginalConstructor() // This is necessary in actual program
            ->getMock();
        $client->expects($this->once())
            ->method('getBankAccount')
            ->will($this->returnValue($bankAccount));

        $this->expectException(WithoutBalanceRuleException::class);
        $this->instance->parseOrFail($client);
        $this->exactly();

    }


    public function testParseOrFailBalancePositive()
    {

        $bankAccount = $this->getMockBuilder(BankAccountInterface::class)
            ->onlyMethods(['getBalance','getAgency','getAccount','getClient','id'])
            ->getMock();

        $bankAccount->expects($this->once())
            ->method('getBalance')
            ->willReturn(self::VALUE * 3 + 0.10);

        $client = $this->getMockBuilder(ClientInterface::class)
            ->disableOriginalConstructor() // This is necessary in actual program
            ->getMock();
        $client->expects($this->once())
            ->method('getBankAccount')
            ->willReturn($bankAccount);

//        $bankAccount = \Mockery::mock(BankAccountInterface::class);
//        $bankAccount
//            ->shouldReceive('getBalance')
//            ->once()
//            ->andReturn(self::VALUE *2)->getMock();
//
//        $client = \Mockery::mock(ClientInterface::class);
//        $client
//            ->shouldReceive('getBankAccount')
//            ->once()
//            ->andReturn($bankAccount)->getMock();

        $response = $this->instance->parseOrFail($client);
        $this->assertTrue($response);

//        \Mockery::close();

    }



}
