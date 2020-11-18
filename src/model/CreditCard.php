<?php
/**
 * Created by PhpStorm.
 * User: xortiz
 * Date: 07/09/2016
 * Time: 06:15 PM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class CreditCard
 * @package hotelbeds\hotel_api_sdk\model
 * @property string code Credit card code
 * @property string name Credit card name
 * @property string paymentType Credit card payment type
 */
class CreditCard extends ApiModel
{
    public function __construct(array $data=null)
    {
        $this->validFields =
            ["code" => "string",
             "name" => "string",
             "paymentType" => "string"
            ];
        if ($data !== null)
        {
            $this->fields = $data;
        }
    }
}