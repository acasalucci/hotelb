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
use hotelbeds\hotel_api_sdk\types\ApiVersion;
use hotelbeds\hotel_api_sdk\types\ApiVersions;
use hotelbeds\hotel_api_sdk\messages\BookingListRS;

class BookingApiTest extends PHPUnit\Framework\TestCase
{
    private $apiClient;

    protected function setUp()
    {
        $reader = new Laminas\Config\Reader\Ini();
        $commonConfig   = $reader->fromFile(__DIR__ . '/config/Common.ini');
        $currentEnvironment = $commonConfig["environment"]? $commonConfig["environment"]: "DEFAULT";
        $environmentConfig   = $reader->fromFile(__DIR__ . '/config/Environment.' . strtoupper($currentEnvironment) . '.ini');
        $cfgApi = $commonConfig["apiclient"];
        $cfgUrl = $environmentConfig["url"];

        $this->apiClient = new HotelApiClient($cfgUrl["default"],
            $cfgApi["apikey"],
            $cfgApi["sharedsecret"],
            new ApiVersion(ApiVersions::V1_0),
            $cfgApi["timeout"]);
    }

    public function testBookingList()
    {
        $rqBookingLst = new \hotelbeds\hotel_api_sdk\helpers\BookingList();
        $rqBookingLst->start = DateTime::createFromFormat("Y-m-d", "2016-04-01");
        $rqBookingLst->end = DateTime::createFromFormat("Y-m-d", "2016-04-30");
        $rqBookingLst->from = 1;
        $rqBookingLst->to = 25;
        return $this->apiClient->bookinglist($rqBookingLst);
    }

    /**
     * @depends testBookingList
     */

    public function testBookingListRS(BookingListRS $bkListRS)
    {
        $firstBooking = null;
        // Check is response is empty or not
        $this->assertFalse($bkListRS->isEmpty(), "Booking list is empty!");
        foreach ($bkListRS->bookings->iterator() as $reference => $booking)
        {
            $this->assertNotEmpty($reference);
            $this->assertNotEmpty($booking->creationDate);
            if ($booking->status === "CONFIRMED") {
                print_r($booking);
                $firstBooking = $booking->reference;
            }
        }

        return $firstBooking;
    }

    /**
     * @depends testBookingListRS
     */

    public function testBookingCancellation($bookingId)
    {
           try {
                $this->apiClient->bookingCancellation($bookingId);
           } catch (\hotelbeds\hotel_api_sdk\types\HotelSDKException $e) {
               echo "\n".$e->getMessage()."\n";
               $this->fail($e->getMessage());
           }
    }

    protected function tearDown()
    {

    }
}
