<?php
/**
 * Created by PhpStorm.
 * User: xortiz
 * Date: 08/09/2016
 * Time: 08:00 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class DailyRate
 * @package hotelbeds\hotel_api_sdk\model
 * @property integer offset Offset price
 * @property double dailyNet Net price
 * @property double dailySellingRate price
 */

class DailyRate extends ApiModel
{
    public function __construct(array $data=null)
    {
        $this->validFields = [
            "offset" => "integer",
            "dailyNet" => "double",
            "dailySellingRate" => "double"
        ];

        if ($data !== null)
        {
           $this->fields = $data;
        }
    }
}