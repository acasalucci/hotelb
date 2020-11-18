<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 10/23/2015
 * Time: 12:36 AM
 */

namespace hotelbeds\hotel_api_sdk\messages;

/**
 * Interface ApiCallTypes
 * @package hotelbeds\hotel_api_sdk\messages
 */
interface ApiCallTypes
{
    const AVAILABILITY = "hotels";
    const BOOKING = "bookings";
    const CHECK_AVAIL = "checkrates";
    const STATUS = "status";
}