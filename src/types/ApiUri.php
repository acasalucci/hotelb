<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 10/27/2015
 * Time: 3:15 AM
 */

namespace hotelbeds\hotel_api_sdk\types;

use Laminas\Uri\Http;
use StringTemplate;

/**
 * Class ApiUri
 * @package hotelbeds\hotel_api_sdk\types
 */
class ApiUri extends Http
{
    const BASE_PATH='/hotel-api';
    const API_URI_FORMAT = '{basepath}/{version}';

    /**
     * Prepare URL for the operation
     * @param ApiVersion $version Version of API used for client
     */
    public function prepare(ApiVersion $version)
    {
        $strSubs = new StringTemplate\Engine;
        $this->setPath($strSubs->render(self::API_URI_FORMAT,
            ["basepath"  => self::BASE_PATH,
             "version"   => $version->getVersion()]));
    }
}