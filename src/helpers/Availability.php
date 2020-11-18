<?php
/**
 * Created by PhpStorm.
 * User: vmavromatis
 * Date: 03/09/2018
 * Time: 11:29 PM
 */

namespace hotelbeds\hotel_api_sdk\helpers;
use hotelbeds\hotel_api_sdk\model\Destination;
use hotelbeds\hotel_api_sdk\model\Filter;
use hotelbeds\hotel_api_sdk\model\Geolocation;
use hotelbeds\hotel_api_sdk\model\Stay;
use hotelbeds\hotel_api_sdk\model\Boards;

/**
 * Class Availability
 * @package hotelbeds\hotel_api_sdk\helpers
 * @property Stay $stay Booking length of stay element
 * @property array $occupancies In the occupancy node the following must be informed: the number of rooms, capacity, number of adults, number of children and children ages if applicable.
 * @property Destination $destination Destination element: Destination code, zone
 * @property Geolocation $geolocation Geolocation element: longitude, latitude
 * @property array $keywords Array of keywords to be searched.
 * @property array $hotels Array of code of hotels to be filtered.
 * @property string $sourceMarket Hotelbeds Group client source market
 * @property boolean $dailyRate Display the rate day by day
 * @property string $language Language of the response
 * @property Filter $filter Filters for availability
 * @property Boards $boards Boards for availability
 * @property array $accommodations Array of accommodation strings to filter by APARTMENT,APTHOTEL,CAMPING,HOMES,HOSTEL,HOTEL,PENDING,RESORT,RURAL
 */

class Availability extends ApiHelper
{
    /**
     * Availability constructor.
     */
    public function __construct()
    {
        $this->validFields = [
                "stay" => "hotelbeds\\hotel_api_sdk\\model\\Stay",
                "occupancies" => "array",
                "geolocation" => "hotelbeds\\hotel_api_sdk\\model\\Geolocation",
                "destination" => "hotelbeds\\hotel_api_sdk\\model\\Destination",
                "keywords" => "array",
                "hotels" => "array",
                "boards" => "hotelbeds\\hotel_api_sdk\\model\\Boards",
                "sourceMarket" => "string",
                "dailyRate" => "boolean",
                "language" => "string",
                "accommodations"=> "array",
                "filter" => "hotelbeds\\hotel_api_sdk\\model\\Filter"
                ];
    }
}
