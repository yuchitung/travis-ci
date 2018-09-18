<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:44
 */

namespace App;

class Context
{
    public static $profiles = [
        'joey' => '91',
        'mei' => '99',
    ];
    public static function getPassword($key)
    {
        return static::$profiles[$key];
    }
}