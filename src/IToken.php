<?php

namespace App;

interface IToken
{
    public function getRandom($account);
}