<?php
/**
 * Created by PhpStorm.
 * User: xortiz
 * Date: 07/09/2016
 * Time: 06:21 PM
 */

namespace hotelbeds\hotel_api_sdk\model;

class CreditCardIterator implements \Iterator
{
    private $creditcards, $position = 0;

    public function __construct(array $creditcards)
    {
        $this->creditcards = $creditcards;
    }

    public function current()
    {
        return new CreditCard($this->creditcards[$this->position]);
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->creditcards[$this->position]["code"];
    }

    public function valid()
    {
        return ( $this->position < count($this->creditcards) );
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
