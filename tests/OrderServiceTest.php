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
        /**
         * @var m\MockInterface
         */
        private $target;
        /**
         * @var MockInterface
         */
        private $spyBookDao;

        protected function setUp()
        {
//            $this->target = new OrderServiceForTest();
            $this->target = m::mock(OrderService::class)->makePartial();
            $this->target->shouldAllowMockingProtectedMethods();

            $this->spyBookDao = m::spy(IBookDao::class);
            $this->target->shouldReceive('getBookDao')->andReturn($this->spyBookDao);
        }

        public function test_sync_book_orders_3_orders_only_2_book_order()
        {
            $this->givenOrders(['Book', 'CD', 'Book']);

            $this->target->syncBookOrders();

            $this->bookDaoShouldInsertTimes(2);
        }

        /**
         * @param $type
         * @return Order
         */
        private function createOrder($type)
        {
            $order = new Order();
            $order->type = $type;

            return $order;
        }

        /**
         * @param $types
         */
        private function givenOrders($types)
        {
            $orders = [];
            $i = 0;
            foreach ($types as $type) {
                $orders[$i] = $this->createOrder($type);
                $i++;
            }

            $this->target->shouldReceive('getOrders')->andReturn($orders);
//            $this->target->setOrders($orders);
        }

        private function bookDaoShouldInsertTimes($times)
        {
            $this->spyBookDao->shouldHaveReceived('insert')->with(m::on(function (Order $order) {
                return $order->type == 'Book';
            }))->times($times);
        }
    }
}
//
//namespace App {
//    class OrderServiceForTest extends OrderService
//    {
//        private $orders;
//        private $bookDao;
//
//        public function setBookDao($bookDao)
//        {
//            $this->bookDao = $bookDao;
//        }
//
//        protected function getBookDao()
//        {
//            return $this->bookDao;
//        }
//
//        public function setOrders($orders)
//        {
//            $this->orders = $orders;
//        }
//
//        protected function getOrders()
//        {
//            return $this->orders;
//        }
//    }
//}
