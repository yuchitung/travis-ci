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
    use PHPUnit\Framework\TestCase;
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
    use Mockery as m;


    class OrderServiceTest extends TestCase
    {

        use MockeryPHPUnitIntegration;
        private $target;

        /**
         * @var m\MockInterface
         */
        private $spyBookDao;

        protected function setUp()
        {
            parent::setUp();
            /**
             * 使用 makePartial mock 指定函數，取代自己建立 fake object 的形式
             */
            $this->target = m::mock(OrderService::class)->makePartial();
            $this->target->shouldAllowMockingProtectedMethods();

            $this->spyBookDao = m::spy(IBookDao::class);
            $this->target->shouldReceive('getBookDao')->andReturn($this->spyBookDao);
        }

        /** @test */
        public function test_sync_book_orders_3_orders_only_2_book_order()
        {
            $this->givenOrders(['Book', 'CD', 'Book']);

            $this->target->syncBookOrders();

            $this->shouldInsertBookDao(2);
        }

        /**
         * @param $type
         * @return Order
         */
        protected function createOrder($type): Order
        {
            $order = new Order();
            $order->type = $type;
            return $order;
        }

        /**
         * @param $types
         * @return array
         */
        protected function createOrders($types): array
        {
            $orders = [];
            foreach ($types as $type) {
                $orders[] = $this->createOrder($type);
            }

            return $orders;
        }

        protected function givenOrders($types): void
        {
            $stubOrders = $this->createOrders($types);
            $this->target->shouldReceive('getOrders')->andReturn($stubOrders);
        }

        protected function shouldInsertBookDao($times): void
        {
            $this->spyBookDao->shouldHaveReceived('insert')->with(m::on(function (Order $order) {
                return $order->type === 'Book';
            }))->times($times);
        }
    }

}

