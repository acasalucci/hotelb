<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/13/2015
 * Time: 5:46 PM
 */

namespace hotelbeds\hotel_api_sdk\model;
/**
 * Class Promotion
 * @package hotelbeds\hotel_api_sdk\model
 * @property string code Id of promotion
 * @property string name Description of promotion
 * @property string remark
 * @property string sequence

 */
class Promotion extends ApiModel
{
    public function __construct(array $data=null)
    {
        $this->validFields = [
            "code" => "string",
            "name" => "string",
            "sequence" => "string",
            "remark" => "string"
        ];

        if ($data !== null)
        {
            $this->fields = $data;
        }
    }
}