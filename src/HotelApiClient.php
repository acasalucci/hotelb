<?php
/**
 * #%L
 * hotel-api-sdk
 * %%
 * Copyright (C) 2015 HOTELBEDS, S.L.U.
 * %%
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 2.1 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Lesser Public License for more details.
 *
 * You should have received a copy of the GNU General Lesser Public
 * License along with this program.  If not, see
 * <http://www.gnu.org/licenses/lgpl-2.1.html>.
 * #L%
 */

namespace hotelbeds\hotel_api_sdk;

use hotelbeds\hotel_api_sdk\messages\StatusRS;

use hotelbeds\hotel_api_sdk\messages\AvailabilityRS;
use hotelbeds\hotel_api_sdk\helpers\Availability;

use hotelbeds\hotel_api_sdk\messages\CheckRateRS;
use hotelbeds\hotel_api_sdk\helpers\CheckRate;

use hotelbeds\hotel_api_sdk\messages\BookingConfirmRS;
use hotelbeds\hotel_api_sdk\helpers\Booking;

use hotelbeds\hotel_api_sdk\messages\BookingListRS;
use hotelbeds\hotel_api_sdk\helpers\BookingList;

use hotelbeds\hotel_api_sdk\model\AuditData;
use hotelbeds\hotel_api_sdk\types\ApiVersion;
use hotelbeds\hotel_api_sdk\types\ApiVersions;
use hotelbeds\hotel_api_sdk\types\HotelSDKException;
use hotelbeds\hotel_api_sdk\messages\ApiRequest;

use Laminas\Http\Client;
use Laminas\Http\Request;
use Laminas\Http\Response;
use Laminas\Uri\UriFactory;

/**
 * Class HotelApiClient. This is the main class of the SDK that makes client-api hotel. Mainly this class is used to make all calls to the hotel-api webservice using ApiHelper classes
 * @package hotelbeds\hotel_api_sdk
 * @method StatusRS Status() Get status of hotel-api service
 * @method AvailabilityRS Availability(Availability $availData) Do availability accommodation request
 * @method CheckRateRS CheckRate(CheckRate $rateData) Check different room rates for booking
 * @method BookingConfirmRS BookingConfirm(Booking $bookingData) Method allows confirmation of the rate keys selected.  There is an option of confirming more than one rate key for the same hotel/room/board.
 * @method BookingCancellationRS BookingCancellation( $bookingId ) Method can cancel confirmed booking
 * @method BookingListRS BookingList( BookingList $bookData ) To get a list of bookings
 */
class HotelApiClient
{
    /**
     * @var ApiUri Well formatted URI of service
     */
    private $apiUri;
    
    /**
     * @var ApiUri Well formatted URI of service for payments
     */
    private $apiPaymentUri;

    /**
     * @var string Stores locally client api key
     */
    private $apiKey;

    /**
     * @var string Stores locally client shared secret
     */
    private $sharedSecret;

    /**
     * @var Client HTTPClient object
     */
    private $httpClient;

    /**
     * @var Request Last sent request
     */
    private $lastRequest;

    /**
     * @var Response Last sent request
     */
    private $lastResponse;

    /**
     * HotelApiClient Constructor they initialize SDK Client.
     * @param string $url Base URL of hotel-api service.
     * @param string $apiKey Client APIKey
     * @param string $sharedSecret Shared secret
     * @param ApiVersion $version Version of HotelAPI Interface
     * @param int $timeout HTTP Client timeout
     * @param string $adapter Customize adapter for http request
     * @param string $secureUrl Customize Base URL of hotel-api secure service.
     */
    public function __construct($url, $apiKey, $sharedSecret, ApiVersion $version, $timeout=30, $adapter=null, $secureUrl=null)
    {
        $this->lastRequest = null;
        $this->apiKey = trim($apiKey);
        $this->sharedSecret = trim($sharedSecret);
        $this->httpClient = new Client();
        if($adapter!=null) {
            $this->httpClient->setOptions([
            		"adapter" => $adapter,
            		"timeout" => $timeout
            ]);
        }else{
            $this->httpClient->setOptions([
            		"timeout" => $timeout
            ]);
        }
        UriFactory::registerScheme("https","hotelbeds\\hotel_api_sdk\\types\\ApiUri");
        $this->apiUri = UriFactory::factory($url);
        $this->apiUri->prepare($version);
        $this->apiPaymentUri = UriFactory::factory($secureUrl?$secureUrl:$url);
        $this->apiPaymentUri->prepare($version);
    }

    /**
     * @param $sdkMethod string Method request name.
     * @param $args array only specify a ApiHelper class type for encapsulate request arguments
     * @return ApiResponse Class of response. Each call type returns response class: For example AvailabilityRQ returns AvailabilityRS
     * @throws HotelSDKException Specific exception of call
     */

    public function __call($sdkMethod, array $args=null)
    {
        $sdkClassRQ = "hotelbeds\\hotel_api_sdk\\messages\\".$sdkMethod."RQ";
        $sdkClassRS = "hotelbeds\\hotel_api_sdk\\messages\\".$sdkMethod."RS";

        if (!class_exists($sdkClassRQ) && !class_exists($sdkClassRS)){
            throw new HotelSDKException("$sdkClassRQ or $sdkClassRS not implemented in SDK");
        }
        if($sdkClassRQ == "hotelbeds\\hotel_api_sdk\\messages\\BookingConfirmRQ"){
        	$req = new $sdkClassRQ($this->apiUri, $this->apiPaymentUri, $args[0]);
        }else{
	        if ($args !== null && count($args) > 0){
	            $req = new $sdkClassRQ($this->apiUri, $args[0]);
	        } else {
	        	$req = new $sdkClassRQ($this->apiUri);
	        }
        }
        return new $sdkClassRS($this->callApi($req));
    }

    /**
     * Generic API Call, this is a internal used method for sending all requests to webservice and parse
     * JSON response and transforms to PHP-Array object.
     * @param ApiRequest $request API Abstract request helper for construct request
     * @return array Response data into PHP Array structure
     * @throws HotelSDKException Calling exception, can capture remote server auditdata if exists.
     */
    private function callApi(ApiRequest $request)
    {
        try {
            $signature = hash("sha256", $this->apiKey.$this->sharedSecret.time());
            $this->lastRequest = $request->prepare($this->apiKey, $signature);
            $response = $this->httpClient->send($this->lastRequest);
            $this->lastResponse = $response;
        } catch (\Exception $e) {
            throw new HotelSDKException("Error accessing API: " . $e->getMessage());
        }

        if ($response->getStatusCode() !== 200) {
           $auditData = null;$message=''; $errorResponse = null;
           if ($response->getBody() !== null) {
               try {
                   $errorResponse = \Laminas\Json\Json::decode($response->getBody(), \Laminas\Json\Json::TYPE_ARRAY);
                   $auditData = new AuditData($errorResponse["auditData"]);
                   $message =$errorResponse["error"]["code"].' '.$errorResponse["error"]["message"];
               } catch (\Exception $e) {
                   throw new HotelSDKException($response->getReasonPhrase().': '.$response->getBody());
               }
           }
            throw new HotelSDKException($response->getReasonPhrase().': '.$message, $auditData);
        }

        return \Laminas\Json\Json::decode(mb_convert_encoding($response->getBody(),'UTF-8'), \Laminas\Json\Json::TYPE_ARRAY);
    }

    /**
     * @return Request getLastRequest Returns entire raw request
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return Response getLastResponse Returns entire raw response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }


}
