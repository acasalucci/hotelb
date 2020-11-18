<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/12/2015
 * Time: 1:33 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Hotels
 * @package hotelbeds\hotel_api_sdk\model
 * @property integer total Total number of hotels
 */
class Hotels extends ApiModel
{
    public function __construct(array $data = null)
    {
        $this->validFields = [
            "hotels" => "array",
            "checkIn" => "DateTime",
            "checkOut" => "DateTime",
            "total" => "integer"
        ];

        if ($data !== null) {
            $this->fields = $data;
        }
    }

    /**
     * @return HotelIterator For iterate hotels list
     */
    public function iterator()
    {
        if ($this->hotels !== null)
            return new HotelIterator($this->hotels);
        return new HotelIterator([]);
    }

}