<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/24/2015
 * Time: 1:39 AM
 */

namespace hotelbeds\hotel_api_sdk\messages;

use hotelbeds\hotel_api_sdk\helpers\CheckRate;
use hotelbeds\hotel_api_sdk\types\ApiUri;
use Laminas\Http\Request;

class CheckRateRQ extends ApiRequest
{
    public function __construct(ApiUri $baseUri, CheckRate $checkDataRQ)
    {
        parent::__construct($baseUri, self::CHECK_AVAIL);
        $this->request->setMethod(Request::METHOD_POST);
        $this->setDataRequest($checkDataRQ);
    }
}