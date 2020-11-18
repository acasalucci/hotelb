<?php
/**
 * Created by PhpStorm.
 * User: vmavromatis
 * Date: 05/09/2017
 * Time: 16:29
 */


require __DIR__ .'/../vendor/autoload.php';

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
$config = $reader->fromFile(__DIR__.'/HotelApiClient.ini');
$cfgApi = $config["apiclient"];

$apiClient = new HotelApiClient($cfgApi["url"],
    $cfgApi["apikey"],
    $cfgApi["sharedsecret"],
    new ApiVersion(ApiVersions::V1_2), 
    $cfgApi["timeout"]); //Make sure you use 1.2 for no CC details and 1.0 version for CC details w/ secure URL.

$rateKey = urldecode($_GET['ratekey']);
//$rateKey = "20191215|20191220|W|1|1072|JSU.ST|NRF-TODOS RO1|RO||1~2~1|8|N@02~~10FFD24D532D4E0156473431668200AAES0000003000200020625a207";

//$paxes = [ new Pax(Pax::AD, 30, "Miquel", "Fiol",1), new Pax(Pax::AD, 27, "Margalida", "Soberats",1), new Pax(Pax::CH, 8, "Josep", "Fiol",1) ];
$paxes = [ new Pax(Pax::AD, 30, "Mike", "Doe", 1), new Pax(Pax::AD, 27, "Jane", "Doe", 1), new Pax(Pax::CH, 8, "Mack", "Doe", 1) ];
//$paxes = [ new Pax(Pax::AD, 30, "Mike", "Doe", 1) ];

$rqBookingConfirm = new \hotelbeds\hotel_api_sdk\helpers\Booking();
$rqBookingConfirm->holder = new \hotelbeds\hotel_api_sdk\model\Holder("Hotelbeds", "SDK Test");
$rqBookingConfirm->language="ENG";
$rqBookingConfirm->tolerance=2.00;

$bookingRoom = new \hotelbeds\hotel_api_sdk\model\BookingRoom($rateKey);
$bookingRoom->paxes = $paxes;
$bookRooms[] = $bookingRoom;
$rqBookingConfirm->rooms = $bookRooms;

$rqBookingConfirm->clientReference = "PHP_DEMO";



try {
    $confirmRS = $apiClient->BookingConfirm($rqBookingConfirm);

    echo "
    <style>
    table {border-collapse:collapse; table-layout:fixed; width:300px;}
   table td {border:solid 1px #c4e3f3; width:200px; word-wrap:break-word;}
    </style>
    ";
    echo "<b>Booking Raw Request <a href='https://developer.hotelbeds.com/docs/read/apitude_booking/Booking#request-parameters'>(View Documentation)</a></b><br>";
    echo "<pre>".json_encode($rqBookingConfirm->toArray(), JSON_PRETTY_PRINT)."</pre>";

    echo "<br><br>";

    echo "<b>Booking Response <a href='https://developer.hotelbeds.com/docs/read/apitude_booking/Booking#response-parameters'>(View Documentation)</a></b><br>";

    echo "<table border='1'>";
    echo "<tr><td>Status</td><td>".$confirmRS->booking->status."</td>";
    echo "<tr><td>Reference</td><td>".$confirmRS->booking->reference."</td>";
    echo "<tr><td>Name</td><td>".$confirmRS->booking->holder['name']."</td>";
    echo "<tr><td>Surname</td><td>".$confirmRS->booking->holder['surname']."</td>";
    echo "<tr><td>Total Net amount</td><td>".$confirmRS->booking->totalNet."</td>";
    echo "<tr><td>Currency</td><td>".$confirmRS->booking->currency."</td>";

    echo '</table><br><br>';

    echo "<b>Booking Raw Response <a href='https://developer.hotelbeds.com/docs/read/apitude_booking/Booking#response-parameters'>(View Documentation)</a></b><br>";
    echo "<pre>".json_encode($confirmRS->booking->toArray(), JSON_PRETTY_PRINT)."</pre>";

    return $confirmRS;
} catch (\hotelbeds\hotel_api_sdk\types\HotelSDKException $e) {
    echo "\n".$e->getMessage()."\n";
    echo "<br><br>".$apiClient->getLastRequest();
}

/* Test Booking list
$rqBookingList = new \hotelbeds\hotel_api_sdk\helpers\BookingList();
$rqBookingList->start= DateTime::createFromFormat("Y-m-d", "2018-05-01");
$rqBookingList->end= DateTime::createFromFormat("Y-m-d", "2018-05-30");
$rqBookingList->filterType = "CREATION";
$rqBookingList->status = "ALL";
$rqBookingList->from = 1;
$rqBookingList->to = 25;
try {
    echo "\n---TEST BOOKING LIST---\n";
    $bookingListRS = $apiClient->BookingList($rqBookingList);
    echo "<pre>".json_encode($bookingListRS->bookings->toArray(), JSON_PRETTY_PRINT)."</pre>";
    echo "<pre>".json_encode($bookingListRS->bookings->iterator()->current()->reference, JSON_PRETTY_PRINT)."</pre>";
}
catch (\hotelbeds\hotel_api_sdk\types\HotelSDKException $e) {
    echo "\n" . $e->getMessage() . "\n";
    echo "<br><br>" . $apiClient->getLastRequest();
}
*/
return null;
