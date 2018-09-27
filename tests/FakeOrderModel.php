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
    private $insertCallback;
    private $updateCallback;

    public function __construct()
    {
    }

    public function save(MyOrder $order, callable $insertCallback, callable $updateCallback)
    {
        $this->insertCallback = $insertCallback;
        $this->updateCallback = $updateCallback;
    }

    public function delete(Closure $predicate)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return mixed
     */
    public function getInsertCallback()
    {
        return $this->insertCallback;
    }

    /**
     * @return mixed
     */
    public function getUpdateCallback()
    {
        return $this->updateCallback;
    }
}