<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/29/2015
 * Time: 10:51 PM
 */

namespace hotelbeds\hotel_api_sdk\model;
use hotelbeds\hotel_api_sdk\model\PaymentCard;
use hotelbeds\hotel_api_sdk\model\ContractData;

/**
 * Class PaymentData
 * @package hotelbeds\hotel_api_sdk\model
 * @property PaymentCard paymentCard Payment Card info
 * @property ContractData contactData ContractData
 * @property array billingAddress
 * @property integer webPartner
 * @property array device
 */
class PaymentData extends ApiModel
{
    public function __construct()
    {
        $this->validFields = [
            "paymentCard" => "hotelbeds\\hotel_api_sdk\\model\\PaymentCard",
            "contactData" => "hotelbeds\\hotel_api_sdk\\model\\ContractData",
            "billingAddress" => "array",
            "webPartner" => "integer",
            "device" => "array"
        ];
    }
}