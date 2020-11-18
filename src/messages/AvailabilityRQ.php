<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/1/2015
 * Time: 12:29 AM
 */

namespace hotelbeds\hotel_api_sdk\messages;

use hotelbeds\hotel_api_sdk\types\ApiUri;
use hotelbeds\hotel_api_sdk\helpers\Availability;
use Laminas\Http\Request;

/**
 * Class AvailabilityRQ
 * @package hotelbeds\hotel_api_sdk\messages
 */
class AvailabilityRQ extends ApiRequest
{
    /**
     * AvailabilityRQ constructor.
     * @param ApiUri $baseUri
     * @param Availability $availDataRQ
     */
    public function __construct(ApiUri $baseUri, Availability $availDataRQ)
    {
        parent::__construct($baseUri, self::AVAILABILITY);
        $this->request->setMethod(Request::METHOD_POST);
        $this->setDataRequest($availDataRQ);
    }
}