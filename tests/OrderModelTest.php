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

    protected function setUp()
    {
        parent::setUp();
        $this->repository = m::mock(IRepository::class);
    }

    /** @test */
    public function insert_order()
    {
        $myOrderModel = new MyOrderModel($this->repository);
        $this->repository->shouldReceive('isExist')->andReturn(false);

        $this->repository->shouldReceive('insert')->once();

        $myOrder = new MyOrder();

        $insertFlag = false;
        $insertFunc = function ($order) use (&$insertFlag) {
            $insertFlag = true;
        };

        $updateFlag = false;
        $updateFunc = function ($order) use (&$updateFlag) {
            $updateFlag = true;
        };

        $myOrderModel->save($myOrder, $insertFunc, $updateFunc);

        $this->assertEquals(true, $insertFlag);
        $this->assertEquals(false, $updateFlag);
    }

    /** @test */
    public function update_order()
    {
        // TODO
        $myOrderModel = new MyOrderModel($this->repository);
    }
}
