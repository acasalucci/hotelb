<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/6/2015
 * Time: 1:14 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

class Destination extends ApiModel
{
    public function __construct($code=null)
    {
        $this->validFields = [
            "code" => "string",
            "zone" => "integer" ];
        if ($code !== null)
            $this->code = $code;
    }
}