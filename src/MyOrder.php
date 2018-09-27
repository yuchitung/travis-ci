<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/27
 * Time: 下午 11:06
 */

namespace App;

class MyOrder
{
    public $id;
    public $amount;

    public function __construct($id = null, $amount = null)
    {
        $this->id = $id;
        $this->amount = $amount;
    }
}