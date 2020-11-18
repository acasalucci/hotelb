<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/8/2015
 * Time: 9:12 PM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class KeywordsFilter
 * @package hotelbeds\hotel_api_sdk\model
 * @property string keyword Array of keyword search string
 * @property boolean allIncluded
 */
class KeywordsFilter extends ApiModel
{
    /**
     * KeywordsFilter constructor.
     */
    public function __construct()
    {
        $this->validFields =
            ["keyword" => "string",
             "allIncluded" => "boolean"];
    }
}