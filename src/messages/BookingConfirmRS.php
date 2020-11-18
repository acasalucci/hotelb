<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/30/2015
 * Time: 12:05 AM
 */

namespace hotelbeds\hotel_api_sdk\messages;

use hotelbeds\hotel_api_sdk\model\AuditData;
use hotelbeds\hotel_api_sdk\model\Booking;

/**
 * Class BookingConfirmRS
 * @package hotelbeds\hotel_api_sdk\messages
 */
class BookingConfirmRS extends ApiResponse
{
    /**
     * BookingConfirmRS constructor.
     * @param array $rsData
     */
    public function __construct(array $rsData)
    {
        parent::__construct($rsData);
        if (array_key_exists("booking", $rsData)) {
            $bookingObject = new Booking($this->booking);
            $this->booking = $bookingObject;
        }
    }

    /**
     * Returns an auditdata object with response auditdata
     * @return AuditData Return class of audit
     */
    public function auditData()
    {
        return new AuditData($this->auditData);
    }
}