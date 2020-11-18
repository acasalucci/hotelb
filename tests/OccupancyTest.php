<?php

use \hotelbeds\hotel_api_sdk\model\Occupancy;
use \hotelbeds\hotel_api_sdk\model\Pax;

class OccupancyTest extends PHPUnit\Framework\TestCase
{
    private $occupancy;
    protected function setUp()
    {
        $this->occupancy = new Occupancy();
        $this->occupancy->adults = 1;
        $this->occupancy->children = 1;
        $this->occupancy->rooms = 1;
        $this->occupancy->paxes = [ new Pax(Pax::AD, 30), new Pax(Pax::CH, 8) ];
    }

    public function testConf()
    {
        $this->assertEquals($this->occupancy->adults, 1);
        $this->assertEquals($this->occupancy->children, 1);
        $this->assertEquals($this->occupancy->rooms, 1);
    }

    public function testPaxes()
    {
        $this->assertCount(2, $this->occupancy->paxes);
    }

    /**
     * @depends testConf
     * @depends testPaxes
     */
    public function testJson()
    {
       fwrite(STDERR, json_encode($this->occupancy->toArray())."\n");
    }
}
