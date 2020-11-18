<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/4/2015
 * Time: 8:43 PM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Stay
 * @package hotelbeds\hotel_api_sdk\model
 * @property \DateTime checkIn Date of checkin booking
 * @property \DateTime checkOut Date of checkout booking
 * @property int shiftDays Amount of days after and before the check-in to check availability, keeping the same stay duration
 * @property bool allowOnlyShift Correct shiftDays internal functionality 
 */

class Stay extends ApiModel
{
    public function __construct(\DateTime $checkIn=null, \DateTime $checkOut=null)
    {
        $this->validFields =
            ["checkIn" => "DateTime",
             "checkOut" => "DateTime",
             "shiftDays" => "integer",
             "allowOnlyShift" => "boolean"];

        if ($checkIn !== null)
            $this->checkIn = $checkIn;

        if ($checkOut !== null)
            $this->checkOut = $checkOut;
    }
}
