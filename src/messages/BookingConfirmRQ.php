<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/26/2015
 * Time: 12:12 AM
 */

namespace hotelbeds\hotel_api_sdk\messages;

use hotelbeds\hotel_api_sdk\helpers\Booking;
use hotelbeds\hotel_api_sdk\types\ApiUri;
use Laminas\Http\Request;

/**
 * Class BookingConfirmRQ
 * @package hotelbeds\hotel_api_sdk\messages
 */
class BookingConfirmRQ extends ApiRequest
{
    /**
     * BookingConfirmRQ constructor.
     * @param ApiUri $baseUri Base uri when the request does not include payment data
     * @param ApiUri $basePaymentUri Base uri when the request does include payment data
     * @param Booking $bookingDataRQ
     */
    public function __construct(ApiUri $baseUri, ApiUri $basePaymentUri, Booking $bookingDataRQ)
    {
    	if($bookingDataRQ!=null && $bookingDataRQ->paymentData!=null){
    		parent::__construct($basePaymentUri, self::BOOKING);
    	} else {
        	parent::__construct($baseUri, self::BOOKING);
    	}
        $this->request->setMethod(Request::METHOD_POST);
        $this->setDataRequest($bookingDataRQ);
    }
}
