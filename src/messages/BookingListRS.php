<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/20/2015
 * Time: 2:47 AM
 */

namespace hotelbeds\hotel_api_sdk\messages;

use hotelbeds\hotel_api_sdk\model\AuditData;
use hotelbeds\hotel_api_sdk\model\Bookings;

/**
 * Class BookingListRS
 * @package hotelbeds\hotel_api_sdk\messages
 * @property AuditData auditData Relevant internal information
 * @property Bookings bookings List of bookings
 */

class BookingListRS extends ApiResponse
{
    public function __construct(array $rsData)
    {
        parent::__construct($rsData);
        if (array_key_exists("bookings", $rsData)) {
            $bookingsObject = new Bookings($this->bookings);
            $this->bookings = $bookingsObject;
        }
    }

    /**
     * @return bool Returns True when response hotels list is empty. False otherwise.
     */
    public function isEmpty()
    {
        return ($this->bookings->total === 0);
    }

    /**
     * @return AuditData Return class of audit
     */
    public function auditData()
    {
        return new AuditData($this->auditData);
    }
}