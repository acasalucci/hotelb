<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/24/2015
 * Time: 1:03 AM
 */

namespace hotelbeds\hotel_api_sdk\model;


class BookingIterator implements \Iterator
{
    private $bookings, $position = 0;
    public function __construct(array $bookings)
    {
        $this->bookings = $bookings;
    }

    public function current()
    {
        return new Booking($this->bookings[$this->position]);
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->bookings[$this->position]["reference"];
    }

    public function valid()
    {
        return ( $this->position < count($this->bookings) );
    }

    public function rewind()
    {
        $this->position = 0;
    }
}