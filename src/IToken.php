<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/26
 * Time: 下午 05:18
 */

namespace App;

interface IToken
{
    public function getRandom($account);
}