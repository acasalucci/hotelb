<?php
/**
 * Created by PhpStorm.
 * User: xortiz
 * Date: 08/09/2016
 * Time: 08:09 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class DailyRatesIterator
 * @package hotelbeds\hotel_api_sdk\model
 */
class DailyRatesIterator implements \Iterator
{
    private $dailyrates, $position = 0;
    public function __construct(array $dailyrates)
    {
        $this->dailyrates = $dailyrates;
    }

    public function current()
    {
        return new DailyRate($this->dailyrates[$this->position]);
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->dailyrates[$this->position]["offset"];
    }

    public function valid()
    {
        return ( $this->position < count($this->dailyrates) );
    }

    public function rewind()
    {
        $this->position = 0;
    }
}

