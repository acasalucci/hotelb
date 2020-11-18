<?php
/**
 * Created by PhpStorm.
 * User: xortiz
 * Date: 7/9/2016
 * Time: 8:43 PM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Filter
 * @package hotelbeds\hotel_api_sdk\model
 * @property int maxHotels Maximum number of hotel in response
 * @property int maxRooms Maximum number of rooms you want to receive for each hotel
 * @property int maxRatesPerRoom Maximum number of rates per room
 * @property int minRate It filters rates which ‘net’ value is lower than minRate
 * @property int maxRate It filters rates which ‘net’ value is higher than maxRate
 * @property int packaging Used to include or exclude package rates.
 * @property int paymentType Payment type. Values: AT_WEB(Merchant model), AT_HOTEL(Pay at hotel model) and BOTH(Both(Default value))
 * @property int hotelPackage It is used to include or exclude hotel packages. Those are packages created by us that include another product (like massage, a ticket, etc.) together with the hotel.Values: YES(To retrieve only hotel packages), NO(To retrieve only non hotel packages) and BOTH(To receive both hotel packages and not (option by default))
 * @property int minCategory Minimum category to be returned
 * @property int maxCategory Maximum category to be returned
 * @property string contract Filter only for this contract
 */

class Filter extends ApiModel
{
    public function __construct()
    {
        $this->validFields =
            ["maxHotels" => "integer",
             "maxRooms" => "integer",
             "maxRatesPerRoom" => "integer",
             "minRate" => "double",
             "maxRate" => "double",
             "packaging" => "boolean",
             "paymentType" => "string",
             "hotelPackage" => "string",
             "minCategory" => "integer",
             "maxCategory" => "integer",
             "contract" => "string"
            ];
    }
}
