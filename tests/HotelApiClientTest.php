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

use hotelbeds\hotel_api_sdk\HotelApiClient;
use hotelbeds\hotel_api_sdk\messages\BookingConfirmRS;
use hotelbeds\hotel_api_sdk\messages\CheckRateRS;
use hotelbeds\hotel_api_sdk\model\Destination;
use hotelbeds\hotel_api_sdk\model\Geolocation;
use hotelbeds\hotel_api_sdk\model\Occupancy;
use hotelbeds\hotel_api_sdk\model\Pax;
use hotelbeds\hotel_api_sdk\model\Rate;
use hotelbeds\hotel_api_sdk\model\Stay;
use hotelbeds\hotel_api_sdk\types\ApiVersion;
use hotelbeds\hotel_api_sdk\types\ApiVersions;
use hotelbeds\hotel_api_sdk\messages\AvailabilityRS;
use hotelbeds\hotel_api_sdk\messages\BookingListRS;


class HotelApiClientTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var HotelApiClient
     */
    private $apiClient;

    protected function setUp()
    {
        $reader = new Laminas\Config\Reader\Ini();
        $commonConfig   = $reader->fromFile(__DIR__ . '\config\Common.ini');
        $currentEnvironment = $commonConfig["environment"]? $commonConfig["environment"]: "DEFAULT";
        $environmentConfig   = $reader->fromFile(__DIR__ . '\config\Environment.' . strtoupper($currentEnvironment) . '.ini');
        $cfgApi = $commonConfig["apiclient"];
        $cfgUrl = $environmentConfig["url"];

        $this->apiClient = new HotelApiClient($cfgUrl["default"],
            $cfgApi["apikey"],
            $cfgApi["sharedsecret"],
            new ApiVersion(ApiVersions::V1_0),
            $cfgApi["timeout"],
            null,
            $cfgUrl["secure"]);
    }

    /**
     * API Status Method test
     */

    public function testStatus()
    {
        $this->assertEquals($this->apiClient->Status()->status,"OK");
    }

    /**
     * API Availability method test
     *
     * @depends testStatus
     */

    public function testAvailRQ()
    {
        $rqData = new \hotelbeds\hotel_api_sdk\helpers\Availability();
        $startDate = new DateTime();
        $startDate->modify('+'.rand(1,30).' day');
        $endDate = clone $startDate;
        $endDate->modify('+'.rand(1,10).' day');
        $rqData->stay = new Stay($startDate,$endDate);

        //$rqData->destination = new Destination("PMI");
        $geolocation = new Geolocation();
        $geolocation->latitude = -32.949815300;
        $geolocation->longitude= -60.654034800;
        $geolocation->radius= 5.0;
        $geolocation->unit= Geolocation::KM;

        $rqData->geolocation = $geolocation;

            
        $occupancy = new Occupancy();
        $occupancy->adults = 2;
        $occupancy->children = 1;
        $occupancy->rooms = 1;

        $occupancy->paxes = [ new Pax(Pax::AD, 30, "Miquel", "Fiol"), new Pax(Pax::AD, 27, "Margalida", "Soberats"), new Pax(Pax::CH, 8, "Josep", "Fiol") ];
        $rqData->occupancies = [ $occupancy ];

        return $this->apiClient->Availability($rqData);
    }

    /**
     * Testing AvailabilityRS results of Availability method
     *
     * @depends testAvailRQ
     */

    public function testAvailRS(AvailabilityRS $availRS)
    {
        $firstRate = "";
        // Check is response is empty or not
        $this->assertFalse($availRS->isEmpty(), "Response is empty!");

        // Check some fields of response
        // Iterate response hotels, rooms, rates...

        foreach ($availRS->hotels->iterator() as $hotelCode => $hotelData)
        {
            $this->assertNotEmpty($hotelData->name);

            foreach ($hotelData->iterator() as $roomCode => $roomData)
            {
                $this->assertNotEmpty($roomData->code);
                echo $roomCode."\n";

                foreach($roomData->rateIterator() as $rateKey => $rateData)
                {
                    $firstRate = $rateData;

                    $this->assertNotEmpty($rateData->net);
                    $this->assertNotEmpty($rateData->allotment);
                    $this->assertNotEmpty($rateData->boardCode);

                    // Check cancellation policies
                    foreach($rateData->cancellationPoliciesIterator() as $policyKey => $policyData)
                    {
                        $this->assertNotEmpty($policyData->amount);
                        $this->assertNotEmpty($policyData->from);
                    }

                    // Check taxes
                    $taxes = $rateData->getTaxes();
                    foreach($taxes->iterator() as $tax)
                    {
                            //print_r($tax);
                            //$this->assertNotEmpty($tax->type);
                    }

                    // Promotions
                    foreach($rateData->promotionsIterator() as $promoCode => $promoData )
                    {
                        $this->assertNotEmpty($promoData->name);
                    }
                }

            }
        }

        return $firstRate;
    }

    /**
     * API CheckRate Method test using first ratekey of availiability result test
     *
     * @depends testAvailRS
     */

    public function testCheckRate(Rate $firstRate)
    {
        $this->assertNotEmpty($firstRate->rateKey);
        $this->assertRegExp("/^[0-9]{8}|[0-9]{8}/", $firstRate->rateKey);

        $rqCheck = new \hotelbeds\hotel_api_sdk\helpers\CheckRate();
        $rqCheck->rooms = [ ["rateKey" => $firstRate->rateKey] ];

        return $this->apiClient->checkRate($rqCheck);
    }

    /**
     * @depends testCheckRate
     */

    public function testCheckRateRS(CheckRateRS $checkRS)
    {
        $this->assertNotEmpty($checkRS->hotel->totalNet);
        //$this->assertNotEmpty($checkRS->hotel->totalSellingRate);
        $this->assertNotEmpty($checkRS->hotel->currency);
    }


    /**
     * @depends testCheckRate
     */

    public function testBookingConfirm(CheckRateRS $checkRS)
    {
           $rqBookingConfirm = new \hotelbeds\hotel_api_sdk\helpers\Booking();
           $rqBookingConfirm->holder = new \hotelbeds\hotel_api_sdk\model\Holder("Tomeu TEST", "Capo TEST");
           $rqBookingConfirm->language="CAS";

           // Use this iterator for multiple pax distributions, this example have one only pax distribution.

           $paxes = [ new Pax(Pax::AD, 30, "Miquel", "Fiol",1), new Pax(Pax::AD, 27, "Margalida", "Soberats",1), new Pax(Pax::CH, 8, "Josep", "Fiol",1) ];
           $bookRooms = [];
           $atWeb = false;
           foreach ($checkRS->hotel->iterator() as $roomCode => $roomData)
           {
               if ($roomData->rates[0]["rateType"] !== "BOOKABLE")
                   continue;

               $bookingRoom = new \hotelbeds\hotel_api_sdk\model\BookingRoom($roomData->rates[0]["rateKey"]);
               $bookingRoom->paxes = $paxes;
               $bookRooms[] = $bookingRoom;

               $atWeb = ($roomData->rates[0]["paymentType"] === "AT_WEB");
           }

           // Check all bookable rooms are inserted for confirmation.

           $this->assertNotEmpty($bookRooms);
           $rqBookingConfirm->rooms = $bookRooms;

           // Define payment data for booking confirmation
           $rqBookingConfirm->clientReference = "PHP_TEST_2";
           if (!$atWeb) {
               $rqBookingConfirm->paymentData = new \hotelbeds\hotel_api_sdk\model\PaymentData();

               $rqBookingConfirm->paymentData->paymentCard = [
                   "cardType" => "VI",
                   "cardNumber" => "4444333322221111",
                   "cardHolderName" => "AUTHORISED",
                   "expiryDate" => "0620",
                   "cardCVC" => "123"
               ];

               $rqBookingConfirm->paymentData->contactData = [
                   "email" => "integration@test.com",
                   "phoneNumber" => "654654654"
               ];
           }

           try {
               $confirmRS = $this->apiClient->BookingConfirm($rqBookingConfirm);
               return $confirmRS;
           } catch (\hotelbeds\hotel_api_sdk\types\HotelSDKException $e) {
               echo "\n".$e->getMessage()."\n";
               echo "\n".$this->apiClient->getLastRequest()->getContent()."\n";
               $this->fail($e->getMessage());
           }

           return null;
    }

    /**
     * @depends testBookingConfirm
     */
    public function testBookingRS(BookingConfirmRS $bookingRS)
    {
        $this->assertNotEmpty($bookingRS->booking);
    }


}
