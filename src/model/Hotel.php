<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/8/2015
 * Time: 12:48 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Hotel
 * @package hotelbeds\hotel_api_sdk\model
 * @property integer code Hotelbeds internal hotel code
 * @property string name Hotel name
 * @property string address Hotel address
 * @property string categoryCode Hotel category code
 * @property string categoryName Category name
 * @property string destinationCode Code of the destination where the hotel is located
 * @property string destinationName Name of the destination where the hotel is located
 * @property integer zoneCode Code of the zone where the hotel is located
 * @property string zoneName Name of the zone where the hotel is located
 * @property double latitude Hotel geo latitude
 * @property double longitude Hotel geo longitude
 * @property array rooms List of rooms available for a particular hotel
 * @property string currency Client currency
 * @property double maxRate Maximum hotel room price
 * @property double minRate Minimum hotel room price
 * @property string giata Giata hotel code
 * @property double totalSellingRate
 * @property double totalNet
 * @property array creditCards List of creditCards available for a particular hotel
 * @property \DateTime checkIn check in date
 * @property \DateTime checkOut check out date
 * @property integer exclusiveDeal
 * @property array keyword
 * @property array reviews
 * @property double pendingAmount
 * @property string supplier
 * @property string clientComments
 * @property double cancellationAmount
 * @property array upselling
 * @property boolean isPaymentDataRequired
 */
class Hotel extends ApiModel
{
    public function __construct(array $data=null)
    {
        $this->validFields =
            ["code" => "integer",
             "checkIn" => "DateTime",
             "checkOut" => "DateTime",
             "name" => "string",
             "exclusiveDeal" => "integer",
             "address" => "string",
             "categoryCode" => "string",
             "categoryName" => "string",
             "destinationCode" => "string",
             "destinationName" => "string",
             "zoneCode" => "integer",
             "zoneName" => "string",
             "latitude" => "double",
             "longitude" => "double",
             "rooms" => "array",
             "totalSellingRate" => "double",
             "totalNet" => "double",
             "currency" => "string",
             "maxRate" => "double",
             "minRate" => "double",
             "giata" => "string",
             "keyword" => "array",
             "reviews" => "array",
             "pendingAmount" => "double",
             "supplier" => "string",
             "clientComments" => "string",
             "cancellationAmount" => "double",
             "upselling" => "array",
             "isPaymentDataRequired" => "boolean",
             "creditCards" => "array"
            ];

        if ($data !== null)
        {
            $this->fields = $data;
        }
    }


    /**
     * @return RoomIterator Iterate all rooms of this hotel
     */
    public function iterator()
    {
        if ($this->rooms !== null)
            return new RoomIterator($this->rooms);
        return new RoomIterator([]);
    }

    /**
     * @return CreditCardIterator For iterate creditCard list
     */
    public function creditCardsIterator()
    {
        if ($this->creditCards !== null)
            return new CreditCardIterator($this->creditCards);
        return new CreditCardIterator([]);
    }
}