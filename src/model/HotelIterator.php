<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/12/2015
 * Time: 2:21 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

class HotelIterator implements \Iterator
{
    private $hotels, $position = 0;
    public function __construct(array $hotels)
    {
        $this->hotels = $hotels;
    }

    public function current()
    {
        return new Hotel($this->hotels[$this->position]);
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->hotels[$this->position]["code"];
    }

    public function valid()
    {
        return ( $this->position < count($this->hotels) );
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
