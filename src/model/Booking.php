<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/24/2015
 * Time: 12:14 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Booking
 * @package hotelbeds\hotel_api_sdk\model
 * @property
 */
class Booking extends ApiModel
{
    /**
     * Booking constructor.
     * @param array|null $data
     */
    public function __construct(array $data=null)
    {
        $this->validFields = [
            "reference" => "string",
            "cancellationReference" => "string",
            "clientReference" => "string",
            "modificationPolicies" => "array",
            "creationDate" => "string",
            "creationUser" => "string",
            "totalNet" => "double",
            "totalSellingRate" => "double",
            "pendingAmount" => "double",
            "currency" => "string",
            "status" => "array",
            "holder" => "array",
            "commisionVAT" => "double",
            "agCommision" => "double",
            "remark" => "string",
            "hotel" => "array",
            "invoiceCompany" => "array"
        ];

        if ($data !== null)
        {
            $this->fields = $data;
        }
    }
}
