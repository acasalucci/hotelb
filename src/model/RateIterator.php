<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/12/2015
 * Time: 2:26 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

class RateIterator implements \Iterator
{
    private $rates, $position = 0;
    public function __construct(array $rates)
    {
        $this->rates = $rates;
    }

    public function current()
    {
        return new Rate($this->rates[$this->position]);
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->rates[$this->position]["rateKey"];
    }

    public function valid()
    {
        return ( $this->position < count($this->rates) );
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
