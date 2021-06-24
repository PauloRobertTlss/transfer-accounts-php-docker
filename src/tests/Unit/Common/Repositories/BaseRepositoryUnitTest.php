<?php declare(strict_types=1);

namespace Tests\Unit\Common\Repositories;

use App\Common\Repositories\Contract\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Common\Repositories\BaseRepositoryStub;

class BaseRepositoryUnitTest extends TestCase
{

    /**
     * @var BaseRepositoryStub
     */
    private BaseRepositoryStub $instance;

    protected function setUp(): void
    {
        parent::setUp();
        $this->instance = new BaseRepositoryStub();
    }

    public function testObjectType()
    {
        $this->assertInstanceOf(RepositoryInterface::class, $this->instance);
    }


    public function testHasMethods()
    {
        $this->assertTrue(method_exists($this->instance, 'boot'));
        $this->assertTrue(method_exists($this->instance, 'makeScope'));
    }

    public function testScopeAttributeStartedInstanceModel()
    {
        $reflectionClass = new \ReflectionClass(BaseRepositoryStub::class);
        $reflectionProperty = $reflectionClass->getProperty('scope');
        $reflectionProperty->setAccessible(true);

        $scope = $reflectionProperty->getValue($this->instance);
        $this->assertIsObject($scope);

    }

    public function testAliasAttributeStartedNull()
    {
        $reflectionClass = new \ReflectionClass(BaseRepositoryStub::class);
        $reflectionProperty = $reflectionClass->getProperty('alias');
        $reflectionProperty->setAccessible(true);

        $alias = $reflectionProperty->getValue($this->instance);
        $this->assertEmpty($alias);
    }

    public function testGetTypeErrorException()
    {
        $this->expectException(\TypeError::class);
        $this->instance->create(1111);
    }

    public function testCreateMethod()
    {
        $data = [
            'attribute' => 'xp'
        ];

        $response = $this->instance->create($data);
        $this->assertIsArray($response);
    }



}
