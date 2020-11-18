<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/29/2015
 * Time: 5:12 PM
 */

namespace hotelbeds\hotel_api_sdk\helpers;

use hotelbeds\hotel_api_sdk\model\Holder;
use hotelbeds\hotel_api_sdk\model\PaymentData;

/**
 * Class Booking
 * @package hotelbeds\hotel_api_sdk\helpers
 * @property Holder holder Booking holder information element
 * @property array rooms List of the rooms to be confirmed.
 * @property string clientReference Your internal booking reference or comments
 * @property PaymentData paymentData Payment information. This node must be used if paymentType = 'AT_HOTEL'
 * @property string language Response language 
 * @property string remark Client remark
 * @property integer platform Platform
 * @property double tolerance Margin of price difference (as percentage) accepted when a price difference occurs between Availability/CheckRate and Booking operations.
 */
class Booking extends ApiHelper
{
    public function __construct()
    {
        $this->validFields = [
            "language" => "string",
            "holder" => "hotelbeds\\hotel_api_sdk\\model\\Holder",
            "rooms" => "array",
            "clientReference" => "string",
            "paymentData" => "hotelbeds\\hotel_api_sdk\\model\\PaymentData",
        	"remark" => "string",
        	"platform" => "integer",
            "tolerance" => "double"
        ];
    }
}