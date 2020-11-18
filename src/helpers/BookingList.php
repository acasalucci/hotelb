<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/17/2015
 * Time: 7:22 PM
 */

namespace hotelbeds\hotel_api_sdk\helpers;

/**
 * Class BookingList
 * @package hotelbeds\hotel_api_sdk\helpers
 * @property \DateTime $start Date from when the method will start checking bookings
 * @property \DateTime $end Date to when the method will finish checking bookings.
 * @property integer $from Number "from" of bookings to be returned
 * @property integer $to Number "to" of bookings to be returned
 * @property boolean $includeCancelled The parameter is used to get all bookings including cancelled bookings or excluding cancelled bookings
 * @property string $filterType The parameter is used to identify if the bookings list is by check-in date or by booking creation date.
 * @property string $status The parameter is used to get all bookings, including or excluding cancelled bookings. Values:"ALL" displays all bookings. "CONFIRMED"  displays only confirmed bookings. "CANCELLED"  displays only cancelled bookings.
 * @property string $clientReference Parameter to filter the result by the client reference included in the booking.
 * @property string $country Parameter to filter the results by the country of the hotel.
 * @property string $destination Parameter to filter the results by the destination of the hotel.
 * @property string $hotel Parameter to filter the results by the hotels reserved in the bookings.
 */
class BookingList extends ApiHelper
{
    public function __construct()
    {
        $this->validFields = [
            "start" => "DateTime",
            "end" => "DateTime",
            "from" => "integer",
            "to" => "integer",
            "includeCancelled" => "boolean",
            "filterType" => "string",
            "status" => "string",
            "clientReference" => "string",
            "country" => "string",
            "destination" => "string",
            "hotel" => "string"
        ];
    }
}