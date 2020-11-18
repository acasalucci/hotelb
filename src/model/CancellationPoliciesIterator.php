<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/12/2015
 * Time: 2:29 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class CancellationPoliciesIterator
 * @package hotelbeds\hotel_api_sdk\model
 */
class CancellationPoliciesIterator implements \Iterator
{
    private $cancelPolicies, $position = 0;
    public function __construct(array $policies)
    {
        $this->cancelPolicies = $policies;
    }

    public function current()
    {
        return new CancellationPolicy($this->cancelPolicies[$this->position]);
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->cancelPolicies[$this->position]["from"];
    }

    public function valid()
    {
        return ( $this->position < count($this->cancelPolicies) );
    }

    public function rewind()
    {
        $this->position = 0;
    }
}

