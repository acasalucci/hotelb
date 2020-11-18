<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/24/2015
 * Time: 11:02 PM
 */

namespace hotelbeds\hotel_api_sdk\messages;

use hotelbeds\hotel_api_sdk\model\AuditData;
use hotelbeds\hotel_api_sdk\model\Hotel;

class CheckRateRS extends ApiResponse
{
    public function __construct(array $rsData)
    {
        parent::__construct($rsData);
        if (array_key_exists("hotel", $rsData)) {
            $hotelObject = new Hotel($this->hotel);
            $this->hotel = $hotelObject;
        }
    }

    /**
     * @return AuditData Return class of audit
     */
    public function auditData()
    {
        return new AuditData($this->auditData);
    }
}