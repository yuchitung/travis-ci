<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:44
 */

namespace App;

class ProfileDao
{
    public function getPassword($account)
    {
        return Context::getPassword($account);
    }
}