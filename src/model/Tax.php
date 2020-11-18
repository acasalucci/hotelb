<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/12/2015
 * Time: 12:00 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Tax
 * @package hotelbeds\hotel_api_sdk\model
 * @property boolean included Indicates if the tax is included or not in the price
 * @property double amount Import of the tax
 * @property double clientAmount Import of the tax in hotel currency in case the tax is not included in the price
 * @property string clientCurrency Hotel currency
 * @property string currency Currency of tax (TBC)
 * @property double percent Percentage to be paid at hotel
 * @property string type Tax type. Values: TAX or FEE
 */
class Tax extends ApiModel
{
    public function __construct(array $data=null)
    {
        $this->validFields = [
            "included" => "boolean",
            "amount" => "double",
            "clientAmount" => "double",
            "clientCurrency" => "string",
            "currency" => "string",
            "percent" => "double",
            "type" => "string"
        ];

        if ($data !== null)
        {
            $this->fields = $data;
        }
    }
}