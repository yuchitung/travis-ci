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
        $this->givenDate(12, 25);
        $this->shouldBe("Merry X'mas");
    }

    /**
     * @test
     */
    public function today_is_not_Xmas()
    {
        $this->givenDate(12, 26);
        $this->shouldBe("Today is not X'mas");
    }

    protected function givenDate($month, $day): void
    {
        /**
         * arrange
         */
        $this->holiday->setToday($month . '-' . $day);
    }

    protected function shouldBe($expected): void
    {
        /**
         * act
         */
        $actual = $this->holiday->sayHello();

        /**
         * assert
         */
        $this->assertEquals($expected, $actual);
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
