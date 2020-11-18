<?php
/**
 * Created by PhpStorm.
 * User: Tomeu
 * Date: 11/12/2015
 * Time: 12:48 AM
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class Taxes
 * @package hotelbeds\hotel_api_sdk\model
 * @property boolean allIncluded Informs about if all taxes are included or not
 * @property array taxes List of all taxes
 */
class Taxes extends ApiModel
{
    public function __construct(array $data=null)
    {
        $this->validFields = [
            "allIncluded" => "boolean",
            "taxes" => "array"
        ];

        if ($data !== null)
        {
            $this->fields = $data;
        }
    }

    public function iterator()
    {
        if ($this->taxes !== null)
            return new TaxesIterator($this->taxes);
        return new TaxesIterator([]);
    }
}