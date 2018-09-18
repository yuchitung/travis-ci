<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 09:12
 */

namespace App;

use Closure;

interface IOrderModel
{
    public function save(MyOrder $order, Closure $insertCallback, Closure $updateCallback);

    public function delete(Closure $predicate);
}