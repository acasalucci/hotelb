<?php
/**
 * @author Hotelbeds Group
 */

namespace hotelbeds\hotel_api_sdk\model;

/**
 * Class PaymentCard
 * @package hotelbeds\hotel_api_sdk\model
 * @property string cardType Credit card type
 * @property string cardNumber Credit card number
 * @property string cardHolderName Holder name
 * @property string expiryDate Credit card expiry date
 * @property string cardCVC Credit card CVC
 */
class PaymentCard extends ApiModel
{
    public function __construct($cardType=null, $cardNumber=null, $cardHolderName=null, $expiryDate=null, $cardCVC=null)
    {
            $this->validFields = [
                "cardType" => "string",
            	"cardNumber" => "string",
            	"cardHolderName" => "string",
            	"expiryDate" => "string",
                "cardCVC" => "string"
            ];

            if ($cardType !== null){
                $this->cardType = $cardType;
            }
            if ($cardNumber !== null){
            	$this->cardNumber = $cardNumber;
            }
            if ($cardHolderName !== null){
            	$this->cardHolderName = $cardHolderName;
            }
            if ($expiryDate !== null){
            	$this->expiryDate = $expiryDate;
            }
            if ($cardCVC !== null){
            	$this->cardCVC = $cardCVC;
            }
    }
}