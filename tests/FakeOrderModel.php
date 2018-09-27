<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/28
 * Time: 上午 12:02
 */

namespace App;

use Closure;

class FakeOrderModel implements IOrderModel
{
    private $deletePredicate;

    public function __construct()
    {
    }

    public function save(MyOrder $order, callable $insertCallback, callable $updateCallback)
    {
    }

    public function delete(Closure $predicate)
    {
        $this->deletePredicate = $predicate;
    }

    /**
     * @return mixed
     */
    public function getDeletePredicate()
    {
        return $this->deletePredicate;
    }
}