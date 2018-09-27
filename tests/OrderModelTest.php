<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 09:01
 */

namespace Tests;

use App\IRepository;
use App\MyOrder;
use App\MyOrderModel;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use stdClass;

class OrderModelTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    /**
     * @var MockInterface
     */
    private $repository;
    /**
     * @var MyOrderModel
     */
    private $myOrderModel;

    protected function setUp()
    {
        parent::setUp();
        $this->repository = m::mock(IRepository::class);
        $this->myOrderModel = new MyOrderModel($this->repository);
    }

    /** @test */
    public function insert_order()
    {
        $this->givenOrderIsNotExist();

        $insertCallback = $this->createCallback(1);
        $updateCallback = $this->createCallback(0);
        $this->repoShouldInsertOrder();

        $this->myOrderModel->save(new MyOrder(), $insertCallback, $updateCallback);
    }

    /** @test */
    public function update_order()
    {
        // TODO
        $myOrderModel = new MyOrderModel($this->repository);
    }

    private function givenOrderIsNotExist()
    {
        $this->repository->shouldReceive('isExist')->andReturn(false);
    }

    private function repoShouldInsertOrder()
    {
        $this->repository->shouldReceive('insert')->once();
    }

    /**
     * @param $insertFlag
     */
    private function shouldInvokeInsertClosure($insertFlag)
    {
        $this->assertTrue($insertFlag);
    }

    /**
     * @param $updateFlag
     */
    private function shouldNotInvokeUpdateClosure($updateFlag)
    {
        $this->assertFalse($updateFlag);
    }

    /**
     * @param $expectedInvokedTimes
     * @return array
     */
    private function createCallback($expectedInvokedTimes)
    {
        $mockCallable = m::mock(stdClass::class);
        $mockCallable->shouldReceive('call')->times($expectedInvokedTimes);
        $mockCallback = [$mockCallable, 'call'];

        return $mockCallback;
    }
}
