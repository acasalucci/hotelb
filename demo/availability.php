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
use hotelbeds\hotel_api_sdk\model\Boards;


$reader = new Laminas\Config\Reader\Ini();
$config = $reader->fromFile(__DIR__.'/HotelApiClient.ini');
$cfgApi = $config["apiclient"];

$apiClient = new HotelApiClient($cfgApi["url"],
    $cfgApi["apikey"],
    $cfgApi["sharedsecret"],
    new ApiVersion(ApiVersions::V1_0),
    $cfgApi["timeout"]);

$rqData = new \hotelbeds\hotel_api_sdk\helpers\Availability();
$rqData->stay = new Stay(DateTime::createFromFormat("Y-m-d", "2019-12-15"),
    DateTime::createFromFormat("Y-m-d", "2019-12-20"));

$rqData->hotels = [ "hotel" => [ 1067,1071,1072,1073,1075 ] ];
//$rqData->destination = new Destination("PMI");//By default this search type is disabled
$occupancy = new Occupancy();
$occupancy->adults = 2;
$occupancy->children = 1;
$occupancy->rooms = 1;

$occupancy->paxes = [ new Pax(Pax::AD, 30, "Mike", "Doe"), new Pax(Pax::AD, 27, "Jane", "Doe"), new Pax(Pax::CH, 8, "Mack", "Doe") ];
//$occupancy->paxes = [ new Pax(Pax::AD, 30, "Mike", "Doe", 1) ];

$boards = new Boards();
$boards->included=true;
$boards->board=["RO","BB"];
$rqData->boards=$boards;
//$filter = new \hotelbeds\hotel_api_sdk\model\Filter();
//$filter->contract="FIT-USD";
//$rqData->filter=$filter;

$rqData->occupancies = [ $occupancy ];

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

// Check availability is empty or not!
if (!$availRS->isEmpty()) {
    echo"
    <style>
    table {border-collapse:collapse; table-layout:fixed; width:410px;}
   table td {border:solid 1px #c4e3f3; width:200px; word-wrap:break-word;}
    </style>
    ";

    echo "<b>Availability Raw Request <a href='https://developer.hotelbeds.com/docs/read/apitude_booking/Availability#request-parameters'>(View Documentation)</a></b><br>";
    echo "<table border='1'><tr><td>";
    echo "<pre>".json_encode($rqData->toArray(), JSON_PRETTY_PRINT)."</pre>";
    echo "</td></tr></table>";

    echo "<br><br>";

    echo "<b>Availability Response <a href='https://developer.hotelbeds.com/docs/read/apitude_booking/Availability#response-parameters'>(View Documentation)</a></b><br>";
    echo "<table border='1'>";
    echo "<tr><td>Hotel Code</td><td>Hotel Name</td><td>Room Name</td><td>Room Price</td><td>Rate Type</td><td>Rate Key</td></tr>";
    echo "<tr><td>availabilityRS/hotels/hotel/@code</td>
    <td>availabilityRS/hotels/hotel/@name</td>
    <td>availabilityRS/hotels/hotel/rooms/room/@name</td>
    <td>availabilityRS/hotels/hotel/rooms/room/rates/rate/@net</td>
    <td>availabilityRS/hotels/hotel/rooms/room/rates/rate/@rateType</td>
    <td>availabilityRS/hotels/hotel/rooms/room/rates/rate/@rateKey</td></tr>";

    foreach ($availRS->hotels->iterator() as $hotelCode => $hotelData) {

        foreach ($hotelData->iterator() as $roomCode => $roomData) {

            foreach ($roomData->rateIterator() as $rateKey => $rateData) {
                echo "<tr>";
                echo '<td>'.$hotelData->code.'</td>';
                echo '<td>'.$hotelData->name.'</td>';
                echo '<td>'.$roomData->name.'</td>';
                echo '<td>'.$rateData->net.'</td>';
                echo '<td>'.$rateData->rateType.'</td>';
                if ($rateData->rateType == 'BOOKABLE')
                    echo "<td><a href=booking.php?ratekey=" .urlencode($rateData->rateKey). ">$rateData->rateKey</a></td>";
                else
                    echo "<td><a href=recheck.php?ratekey=" .urlencode($rateData->rateKey). ">$rateData->rateKey</a></td>";
                echo "</tr>";
            }
        }
    }
    echo '</table><br><br>';

    echo "<b>Availability Raw Response <a href='https://developer.hotelbeds.com/docs/read/apitude_booking/Availability#response-parameters'>(View Documentation)</a></b><br>";
    echo "<pre>".json_encode($availRS->hotels->toArray(), JSON_PRETTY_PRINT)."</pre>"; //Array dump of the hotels Response


} else {
    echo "There are no results!";
}
