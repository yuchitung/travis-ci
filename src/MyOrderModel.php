<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 09:13
 */

namespace App;

use Closure;
use DateTime;

class MyOrderModel implements IOrderModel
{
    public function save(MyOrder $order, Closure $insertCallback, Closure $updateCallback)
    {
        if (!$this->repository->isExists($order)) {
            $now = new DateTime('now');
            if ($now->format('w') === '0') {
                $order->amount += 100;
            }
            $this->repository->insert($order);
            $insertCallback($order);
        }
        else {
            $this->repository->update($order);
            $updateCallback($order);
        }
    }

    public function delete(Closure $predicate)
    {
        throw new Exception('Not implemented');
    }
}