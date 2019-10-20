<?php

namespace Tests;

use App\Holiday;
use PHPUnit\Framework\TestCase;

class HolidayTest extends TestCase
{
    private $holiday;

    protected function setUp()
    {
        parent::setUp();
        $this->holiday = new HolidayForTest();
    }

    /**
     * @test
     */
    public function today_is_Xms()
    {
        /**
         * arrange
         */
        $this->holiday->setToday('12-25');
        /**
         * act
         */
        $actual = $this->holiday->sayHello();

        /**
         * assert
         */
        $this->assertEquals("Merry X'mas", $actual);
    }

    /**
     * @test
     */
    public function today_is_not_Xmas()
    {
        /**
         * arrange
         */
        $this->holiday->setToday('12-26');
        /**
         * act
         */
        $actual = $this->holiday->sayHello();
        /**
         * assert
         */
        $this->assertEquals("Today is not X'mas", $actual);
    }
}

class HolidayForTest extends Holiday
{

    private $today;

    public function setToday(string $date)
    {
        $this->today = $date;
    }

    protected function getToday()
    {
        return $this->today;
    }
}
