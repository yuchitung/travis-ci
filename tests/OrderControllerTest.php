<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 09:00
 */

namespace Tests;

use App\FakeOrderModel;
use App\IOrderModel;
use App\MyOrder;
use App\OrderController;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;

class OrderControllerTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    private $model;
    private $orderController;

    protected function setUp()
    {
        $this->model = m::mock(IOrderModel::class);
        $this->orderController = new OrderController($this->model);
    }

    /** @test */
    public function exist_order_should_update()
    {
        $this->givenInvokeUpdateCallback();

        $myOrder = $this->createMyOrder(91, 100);
        $this->orderController->save($myOrder);

        $this->shouldLog(sprintf('update order id:%s with %s successfully!', $myOrder->id, $myOrder->amount));
    }

    /** @test */
    public function no_exist_order_should_insert()
    {
        // TODO
        $model = m::mock(IOrderModel::class);
        $orderController = new OrderController($model);
        $orderController->save(new MyOrder(91, 100));
    }

    /** @test */
    public function verify_lambda_function_of_delete()
    {
//        $model = m::mock(IOrderModel::class);
        $model = new FakeOrderModel();
        $orderController = new OrderController($model);
        $orderController->deleteAmountMoreThan100();

        $deletePredicate = $model->getDeletePredicate();
        $myOrderAmountMoreThan100 = $this->createMyOrder(91, 101);
        $this->assertTrue($deletePredicate($myOrderAmountMoreThan100));

        $myOrderAmountLessThan100 = $this->createMyOrder(91, 100);
        $this->assertFalse($deletePredicate($myOrderAmountLessThan100));
    }

    private function givenInvokeUpdateCallback()
    {
        $this->model->shouldReceive('save')
            ->andReturnUsing(function ($order, $insertCallback, $updateCallback) {
                $updateCallback($order);
            });
    }

    /**
     * @param $expectedString
     */
    private function shouldLog($expectedString)
    {
        $this->expectOutputString($expectedString);
    }

    /**
     * @param $id
     * @param $amount
     * @return MyOrder
     */
    private function createMyOrder($id, $amount)
    {
        return new MyOrder($id, $amount);
    }
}
