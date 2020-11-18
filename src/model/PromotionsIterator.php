<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/14/2015
 * Time: 11:25 PM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class PromotionsIterator
 * @package hotelbeds\hotel_api_sdk\model
 */
class PromotionsIterator implements \Iterator
{
    /**
     * @var array Contains all promotions of iterate
     */
    private $promotions;

    /**
     * @var int actual position of iterator
     */
    private $position = 0;

    /**
     * PromotionsIterator constructor.
     * @param array $promotions Promotions list
     */
    public function __construct(array $promotions)
    {
        $this->promotions = $promotions;
    }

    /**
     * @return Promotion Return actual Promotion object
     */
    public function current()
    {
        return new Promotion($this->promotions[$this->position]);
    }

    /**
     * Next promotion in promotions list
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return a promotion code
     * @return string return a promotion code
     */
    public function key()
    {
        return $this->promotions[$this->position]["code"];
    }

    /**
     * Test if at the end?
     * @return bool
     */
    public function valid()
    {
        return ( $this->position < count($this->promotions) );
    }

    /**
     * Reset promotions cursor.
     */
    public function rewind()
    {
        $this->position = 0;
    }
}