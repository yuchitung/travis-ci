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
            var_dump($orders);

            // only get orders of book
            $ordersOfBook = array_filter($orders, function ($order) {
                return $order->type === 'Book';
            });
            $bookDao = $this->getBookDao();
            foreach ($ordersOfBook as $order) {
                $bookDao->insert($order);
            }
        }

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
         * @return BookDao
         */
        protected function getBookDao()
        {
            return new BookDao();
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