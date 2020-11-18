<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/29/2015
 * Time: 4:53 PM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Holder
 * @package hotelbeds\hotel_api_sdk\model
 * @property string name Booking holder name for all the rooms of the booking.
 * @property string surname Booking holder surname for all rooms of the booking.
 */
class Holder extends ApiModel
{
    public function __construct($name=null, $surname=null)
    {
            $this->validFields = [
                "name" => "string",
                "surname" => "string"
            ];

            if ($name !== null)
                $this->name = $name;

            if ($surname !== null)
                $this->surname = $surname;
    }
}