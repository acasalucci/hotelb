<?php

use hotelbeds\hotel_api_sdk\model\Pax;

class PaxTest extends PHPUnit\Framework\TestCase
{
    private $pax;
    protected function setUp()
    {
        $this->pax = new Pax(Pax::AD, 30);
        $this->pax->name = "Pax name";
        $this->pax->surname = "Pax surname";
    }

    public function testPax()
    {
        $this->assertEquals($this->pax->age, 30);
        $this->assertEquals($this->pax->type, Pax::AD);
    }

    /**
     * @depends testPax
     */
    public function testJson()
    {
        fwrite(STDERR, json_encode($this->pax->toArray())."\n");
    }
}
