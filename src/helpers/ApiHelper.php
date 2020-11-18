<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/4/2015
 * Time: 7:27 PM
 */

namespace hotelbeds\hotel_api_sdk\helpers;

use hotelbeds\hotel_api_sdk\generic\DataContainer;
use Laminas\Json\Json;

abstract class ApiHelper extends DataContainer
{
    public function __toString()
    {
        return Json::encode($this->toArray());
    }
}