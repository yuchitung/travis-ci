<?php

namespace App;

interface IBookDao
{
    public function insert(Order $order);
}