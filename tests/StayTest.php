<?php

/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/4/2015
 * Time: 9:41 PM
 */

class StayTest extends PHPUnit\Framework\TestCase
{
    private $stay;
    protected function setUp()
    {
        $this->stay = new \hotelbeds\hotel_api_sdk\model\Stay();

        $dateIn = DateTime::createFromFormat("Y-m-d", date("Y-m-d"));
        $dateOut = DateTime::createFromFormat("Y-m-d", date("Y-m-d"));;

        $this->stay->checkIn = $dateIn;
        $this->stay->checkOut = $dateOut->add(new DateInterval('P2W'));
        $this->stay->shiftDays = 1;
        $this->stay->allowOnlyShift = false;
    }

    public function testFields()
    {
        $this->assertEquals($this->stay->shiftDays, 1);
        $this->assertFalse($this->stay->allowOnlyShift);
    }

    public function testDates()
    {
        $dateIn = DateTime::createFromFormat("Y-m-d", date("Y-m-d"));
        $dateOut =  DateTime::createFromFormat("Y-m-d", date("Y-m-d"));
        $dateOut->add(new DateInterval('P2W'));

        $this->assertEquals($this->stay->checkIn->getTimestamp(), $dateIn->getTimestamp());
        $this->assertEquals($this->stay->checkOut->getTimestamp(), $dateOut->getTimestamp());
    }

    /**
     * @depends testFields
     * @depends testDates
     */
    public function testJson()
    {
        fwrite(STDERR, json_encode($this->stay->toArray())."\n");
    }
}
