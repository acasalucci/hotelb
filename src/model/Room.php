<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/8/2015
 * Time: 1:30 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Room
 * @package hotelbeds\hotel_api_sdk\model
 * @property integer code Code of room
 * @property string name Name of room
 * @property array rates list of all rates of this room
 * @property array paxes
 * @property integer id
 * @property string supplierReference

 */
class Room extends ApiModel
{
    public function __construct(array $data=null)
    {
        $this->validFields =
            ["code" => "integer",
            "paxes" => "array",
            "id" => "integer",
            "supplierReference" => "string",
            "name" => "string",
            "rates" => "array"];

        if ($data !== null)
        {
            $this->fields = $data;
        }
    }

    public function rateIterator()
    {
        if ($this->rates !== null)
            return new RateIterator($this->rates);
        return new RateIterator([]);
    }
}