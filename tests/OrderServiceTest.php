<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 08:37
 */

namespace Tests;

use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{

    /** @test */
    public function test_sync_book_orders_3_orders_only_2_book_order()
    {
        // hard to isolate dependency to unit test
        // $target = new OrderService();
        // $target->syncBookOrders();
    }
}
