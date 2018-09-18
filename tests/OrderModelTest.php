<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 09:01
 */

namespace Tests;

use App\IRepository;
use App\MyOrderModel;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
class OrderModelTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->repository = m::mock(IRepository::class);
    }

    /** @test */
    public function insert_order()
    {
        // TODO
        $myOrderModel = new MyOrderModel($this->repository);
    }

    /** @test */
    public function update_order()
    {
        // TODO
        $myOrderModel = new MyOrderModel($this->repository);
    }
}
