<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 08:35
 */

namespace App {

    use Exception;

    class OrderService
    {
        private $filePath = __DIR__ . '/testOrders.csv';

        public function syncBookOrders()
        {
            $orders = $this->getOrders();
            // only get orders of book
            $ordersOfBook = array_filter($orders, function ($order) {
                return $order->type === 'Book';
            });
            /**
             * point: 利用 extract & override 隔絕對 bookDao 的依賴
             */
            $bookDao = $this->getBookDao();

            /**
             * 真正要測的地方
             */
            foreach ($ordersOfBook as $order) {
                $bookDao->insert($order);
            }
        }

        /**
         * point: 測試時要利用 override 隔絕 Order 依賴
         */
        protected function getOrders()
        {
            // parse csv file to get orders
            return array_map(function ($line) {
                return $this->mapping($line);
            }, array_map('str_getcsv', file($this->filePath)));
        }

        private function mapping($line)
        {
            $order = new Order;
            $order->productName = $line[0];
            $order->type = $line[1];
            $order->price = (int)$line[2];
            $order->customerName = $line[3];

            return $order;
        }

        /**
         * point: 測試時要利用 override 隔絕 BookDao 的依賴
         * @return IBookDao
         */
        protected function getBookDao(): IBookDao
        {
            $bookDao = new BookDao();
            return $bookDao;
        }
    }

    class Order
    {
        public $type;
        public $price;
        public $productName;
        public $customerName;
    }

    class BookDao implements IBookDao
    {
        public function insert(Order $order)
        {
            // directly depend on some web service
            // $client = new HttpClient();
            // $response = $client->post("http://api.joey.io/Order", $order);
            // $response->statusCode();
            throw new Exception('Not implemented');
        }
    }
}