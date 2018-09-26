<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 08:37
 */

namespace Tests {

    use App\IBookDao;
    use App\Order;
    use App\OrderService;
    use App\OrderServiceForTest;
    use PHPUnit\Framework\TestCase;
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
    use Mockery as m;

    class OrderServiceTest extends TestCase
    {
        use MockeryPHPUnitIntegration;

        /** @test */
        public function test_sync_book_orders_3_orders_only_2_book_order()
        {
//            $target = new OrderService();
            $target = new OrderServiceForTest();
            $order1 = new Order();
            $order1->type = 'Book';

            $order2 = new Order();
            $order2->type = 'CD';

            $order3 = new Order();
            $order3->type = 'Book';
            $orders = [$order1, $order2, $order3];
            $target->setOrders($orders);

            $spyBookDao = m::spy(IBookDao::class);
            $target->setBookDao($spyBookDao);

            $target->syncBookOrders();

            $spyBookDao->shouldHaveReceived('insert')->with(m::on(function (Order $order) {
                return $order->type == 'Book';
            }))->twice();
        }
    }
}

namespace App {
    class OrderServiceForTest extends OrderService
    {
        private $orders;
        private $bookDao;

        public function setBookDao($bookDao)
        {
            $this->bookDao = $bookDao;
        }

        protected function getBookDao()
        {
            return $this->bookDao;
        }

        public function setOrders($orders)
        {
            $this->orders = $orders;
        }

        protected function getOrders()
        {
            return $this->orders;
        }
    }
}
