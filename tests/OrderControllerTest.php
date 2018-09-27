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

    /** @test */
    public function exist_order_should_update()
    {
        $model = m::mock(IOrderModel::class);
        $orderController = new OrderController($model);

        $model->shouldReceive('save')
            ->andReturnUsing(function ($order, $insertCallback, $updateCallback) {
                $updateCallback($order);
            });

        $myOrder = new MyOrder(91, 100);
        $orderController->save($myOrder);

        $this->expectOutputString(sprintf('update order id:%s with %s successfully!', $myOrder->id, $myOrder->amount));
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
        // TODO
        $model = m::mock(IOrderModel::class);
        $orderController = new OrderController($model);
        $orderController->deleteAmountMoreThan100();
    }
}
