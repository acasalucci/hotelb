<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/8/2015
 * Time: 11:45 PM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Geolocation
 * @package hotelbeds\hotel_api_sdk\model
 * @property double longitude
 * @property double latitude
 * @property double radius
 * @property string unit
 */

class Geolocation extends ApiModel
{
    CONST KM='km';
    CONST MI='mi';

    public function __construct()
    {
        $this->validFields = [
            "longitude" => "double",
            "latitude" => "double",
            "radius" => "double",
            "secondaryLatitude" => "double",
            "secondaryLongitude" => "double",
            "unit" => "string"
        ];
    }
}