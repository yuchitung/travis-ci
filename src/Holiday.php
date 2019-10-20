<?php


namespace App;


class Holiday
{
    public function sayHello()
    {
        if ($this->getToday() === '12-25') {
            return "Merry X'mas";
        }
        return "Today is not X'mas";
    }

    protected function getToday()
    {
        return date('Y-m');
    }
}