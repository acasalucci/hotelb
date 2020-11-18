<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/12/2015
 * Time: 2:30 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class TaxesIterator
 * @package hotelbeds\hotel_api_sdk\model
 */
class TaxesIterator implements \Iterator
{
    private $taxes, $position = 0;
    public function __construct(array $taxes)
    {
        $this->taxes = $taxes;
    }

    public function current()
    {
        return new Tax($this->taxes[$this->position]);
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return ( $this->position < count($this->taxes) );
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
