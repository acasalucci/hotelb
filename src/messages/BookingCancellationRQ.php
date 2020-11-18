<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 12/22/2015
 * Time: 1:25 AM
 */

namespace hotelbeds\hotel_api_sdk\messages;

use hotelbeds\hotel_api_sdk\types\ApiUri;
use Laminas\Http\Request;

/**
 * Class BookingCancellationRQ
 * @package hotelbeds\hotel_api_sdk\messages
 */
class BookingCancellationRQ extends ApiRequest
{
    /**
     * BookingCancellationRQ constructor.
     * @param ApiUri $baseUri
     * @param string $bookingId
     */
    public function __construct(ApiUri $baseUri, $bookingId)
    {
        parent::__construct($baseUri, self::BOOKING);
        $this->request->setMethod(Request::METHOD_DELETE);
        $this->baseUri->setPath($baseUri->getPath()."/".self::BOOKING."/$bookingId");
    }
}