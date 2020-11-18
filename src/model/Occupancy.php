<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/5/2015
 * Time: 12:15 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Occupancy
 * @package hotelbeds\hotel_api_sdk\model
 * @property integer rooms Number of rooms
 * @property integer adults
 * @property integer children
 * @property array paxes List of paxes
 */

class Occupancy extends ApiModel
{
    public function __construct()
    {
        $this->validFields =
            ["rooms" => "integer",
             "adults" => "integer",
             "children" => "integer",
             "paxes" => "array"];
    }
}
