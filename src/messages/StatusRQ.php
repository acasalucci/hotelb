<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 10/27/2015
 * Time: 3:09 AM
 */

namespace hotelbeds\hotel_api_sdk\messages;

use hotelbeds\hotel_api_sdk\types\ApiUri;
use Laminas\Http\Request;

class StatusRQ extends ApiRequest
{
    public function __construct(ApiUri $baseUri)
    {
        parent::__construct($baseUri, self::STATUS);
        $this->request->setMethod(Request::METHOD_GET);
    }
}