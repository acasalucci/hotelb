<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/9/2015
 * Time: 1:15 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class CancellationPolicy
 * @package hotelbeds\hotel_api_sdk\model
 * @property double amount Amount that will be charged after date from
 * @property double hotelAmount Amount that will be charged after date from in hotel currency (for pay at hotel model)
 * @property string hotelCurrency Currency of amount
 * @property string from Date from where the amount will be charged
 */

class CancellationPolicy extends ApiModel
{
    public function __construct(array $data=null)
    {
        $this->validFields = [
            "amount" => "double",
            "hotelAmount" => "double",
            "hotelCurrency" => "string",
            "from" => "string"
        ];

        if ($data !== null)
        {
           $this->fields = $data;
        }
    }
}