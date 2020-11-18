<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/29/2015
 * Time: 5:24 PM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class BookingRoom
 * @package hotelbeds\hotel_api_sdk\model
 * @property string rateKey Rate key to be confirmed taken from the previous step.
 * @property array paxes List of paxes of the room.
 */
class BookingRoom extends ApiModel
{
    public function __construct($rateKey=null)
    {
        $this->validFields = [
            "rateKey" => "string",
            "paxes" => "array"
        ];

        if ($rateKey !== null) {
            $this->fields["rateKey"] = $rateKey;
        }
    }
}