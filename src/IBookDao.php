<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/26
 * Time: 下午 07:06
 */

namespace App;

interface IBookDao
{
    public function insert(Order $order);
}