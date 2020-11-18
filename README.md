# hotel-api-sdk-php

## Introduction 
Hotelbeds SDK for PHP is a set of utilities whose main goal is to help in the development of PHP applications that use APItude, the Hotelbeds API.
This is a composer library available on packagist.org repository. 

https://packagist.org/packages/hotelbeds/hotel-api-sdk-php
## Step by Step Guide
https://github.com/hotelbeds-sdk/hotel-api-sdk-php/wiki/Step-by-step-guide-to-start-from-scratch

## License
This softwared is licensed under the LGPL v2.1 license. Please refer to the file LICENSE for specific details and more license and copyright information.

## API Documentation

http://hotelbeds-sdk.github.io/hotel-api-sdk-php/

## Install
Install from console with Composer utility: https://getcomposer.org/download/

```bash
composer require hotelbeds/hotel-api-sdk-php
```

Using Composer Dependency Manager with PHPStorm: http://blog.jetbrains.com/webide/2013/03/composer-support-in-phpstorm/

Important!!! This version is in dev-master@dev version and you need install with:

```bash
composer require "hotelbeds/hotel-api-sdk-php:dev-master@dev"
```
## Testing

In the directory unit tests can find different tests that can be run with phpunit. There are different sets of tests: Availability and bookings.

```bash
.\vendor\bin\phpunit --testsuite availability
```

This testsuite execute: status of API, make availability on PMI destination, select one room and do checkrate and booking.

## Using SDK

### Overview

The HotelApiClient class has different methods that implement the various calls HotelAPI:

* Availability
* CheckRate
* BookingConfirm
* BookingCancellation
* BookingList
* Status

Each method has a parameter that is ApiHelper type, there are four possible types:

* Availability
* CheckRate
* Booking
* BookingList

All responses each call can either iterate using PHP with objects or arrays. Internally converts the JSON response structure PHP associative arrays.

### Important notes

The SDK uses classes with magic properties and methods to document this feature use the standard @property which is used is explained here: http://manual.phpdoc.org/HTMLSmartyConverter/PHP/phpDocumentor/tutorial_tags.property.pkg.html
The different calls made SDK are magical methods also documented by the same method, and depend on the IDE to use if you have visibility of the same when using the auto-complete. The SDK has been tested and certified with the IDE PhpStorm but the user can use the always prefer and when you consider that the auto-complete will work or not depending on whether it supports "@property" or not.

Ensure you have installed openssl and curl extensions to your PHP environment and cacerts paths are set.

### Include library using autoload [PSR-4](http://www.php-fig.org/psr/psr-4/)

```php
<?php
require __DIR__ .'/vendor/autoload.php';

use hotelbeds\hotel_api_sdk\HotelApiClient;
use hotelbeds\hotel_api_sdk\model\Destination;
use hotelbeds\hotel_api_sdk\model\Occupancy;
use hotelbeds\hotel_api_sdk\model\Pax;
use hotelbeds\hotel_api_sdk\model\Rate;
use hotelbeds\hotel_api_sdk\model\Stay;
use hotelbeds\hotel_api_sdk\types\ApiVersion;
use hotelbeds\hotel_api_sdk\types\ApiVersions;
use hotelbeds\hotel_api_sdk\messages\AvailabilityRS;

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

$rqData = new \hotelbeds\hotel_api_sdk\helpers\Availability();
$rqData->stay = new Stay(DateTime::createFromFormat("Y-m-d", "2018-02-01"),
                         DateTime::createFromFormat("Y-m-d", "2018-02-10"));

$rqData->destination = new Destination("PMI");
$occupancy = new Occupancy();
$occupancy->adults = 2;
$occupancy->children = 1;
$occupancy->rooms = 1;

$occupancy->paxes = [ new Pax(Pax::AD, 30, "Mike", "Doe"), new Pax(Pax::AD, 27, "Jane", "Doe"), new Pax(Pax::CH, 8, "Mack", "Doe") ];
$rqData->occupancies = [ $occupancy ];

$availRS = $apiClient->Availability($rqData);
```

Can filter by list of hotels with hotel property:

```php
$rqData->hotels = [ "hotel" => [ 1067, 1070, 1506, ] ];
```

### Exceptions 

In this first version of the SDK there is an exception (HotelSDKException) to handle errors at the service level and to capture data sent by the server to audit the class AuditData:

```php
try {
    $availRS = $apiClient->Availability($rqData);
} catch (\hotelbeds\hotel_api_sdk\types\HotelSDKException $e) {
    $auditData = $e->getAuditData();
    error_log( $e->getMessage() );
    error_log( "Audit remote data = ".json_encode($auditData->toArray()));
    exit();
} catch (Exception $e) {
    error_log( $e->getMessage() );
    exit();
}
```

### Availability

Send availability request:

```php
   $availRS = $apiClient->Availability($rqData);
```

After availability method call can iterate results with iterator or can read with array form.

#### Availability response check

Before use iterators for iterate all results, can pre-check if is empty response with isEmpty() method, this method avoid instantiate all intermediate classes like: Rooms, Rates ...

```php
if ($availRS->isEmpty()) {
   echo "There are no results!"
}
``` 

#### Using arrays

```php
$allResponse = $availRS->hotels->toArray();
``` 

Returns this array structure:
```php
["hotels" => 
        [ ["code" => 1067,
           "name" => "Gran Melia Victoria",
           ...
           "rooms" => [
                "code" => "DBL.VM",
                "name" => "DOUBLE SEA VIEW",
                "rates" => [ 
                        ["rateKey" => "20160201|20160210|W|1|1067|DBL.VM|ID_B2B_24|RO|BARE|1~2~1|8|N@1102568804",
                         "net"     => 9999.99,
                        ],
                        ...
                ],
           ]
          ],
          ...
]           
```

#### Using iterators with objects
```php
// Iterate all returned hotels with an Hotel object
foreach ($availRS->hotels->iterator() as $hotelCode => $hotelData)
{
        // Get all hotel data (from Hotel object $hotelData)
        
        // Iterate all rooms of each hotel
        foreach ($hotelData->iterator() as $roomCode => $roomData)
        {
                // Iterate all rate of each room
                foreach($roomData->rateIterator() as $rateKey => $rateData)
                {
                        
                }
        }
}

```
