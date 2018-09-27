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

        $this->repoShouldInsertOrder();

//        $insertFlag = false;
//        $insertFunc = function ($order) use (&$insertFlag) {
//            $insertFlag = true;
//        };
//
//        $updateFlag = false;
//        $updateFunc = function ($order) use (&$updateFlag) {
//            $updateFlag = true;
//        };
        $insertFunc = m::mock(\stdClass::class);
        $order = new MyOrder();
        $insertFunc->shouldReceive('call')->once();

        $updateFunc = m::mock(stdClass::class);
        $updateFunc->shouldReceive('call')->never();

        $this->myOrderModel->save($order, [$insertFunc, 'call'], [$updateFunc, 'call']);

//        $this->shouldInvokeInsertClosure($insertFlag);
//        $this->shouldNotInvokeUpdateClosure($updateFlag);
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
}
