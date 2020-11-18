<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/24/2015
 * Time: 12:06 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Bookings
 * @package hotelbeds\hotel_api_sdk\model
 * @property array bookings
 * @property integer from
 * @property integer to
 * @property integer total
 */
class Bookings extends ApiModel
{
    public function __construct(array $data=null)
    {
        $this->validFields = [
            "bookings" => "array",
            "from" => "integer",
            "to" => "integer",
            "total" => "integer"
        ];

        if ($data !== null)
        {
            $this->fields = $data;
        }
    }

    public function iterator()
    {
        if ($this->bookings !== null)
            return new BookingIterator($this->bookings);
        return new BookingIterator([]);
    }
}