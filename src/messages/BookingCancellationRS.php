<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 12/25/2015
 * Time: 9:31 PM
 */

namespace hotelbeds\hotel_api_sdk\messages;

use hotelbeds\hotel_api_sdk\model\AuditData;

/**
 * Class BookingCancellationRS
 * @package hotelbeds\hotel_api_sdk\messages
 */
class BookingCancellationRS extends ApiResponse
{
    /**
     * BookingCancellationRS constructor.
     * @param array $rsData Array of data response for populating response object.
     */
    public function __construct(array $rsData)
    {
        parent::__construct($rsData);
    }

    /**
     * Get audit data object from response
     * @return AuditData Return class of audit
     */
    public function auditData()
    {
        return new AuditData($this->auditData);
    }
}