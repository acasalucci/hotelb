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
use hotelbeds\hotel_api_sdk\model\RoomIterator;
use hotelbeds\hotel_api_sdk\types\ApiVersion;
use hotelbeds\hotel_api_sdk\types\ApiVersions;
use hotelbeds\hotel_api_sdk\messages\AvailabilityRS;

$reader = new Laminas\Config\Reader\Ini();
$config = $reader->fromFile(__DIR__.'/HotelApiClient.ini');
$cfgApi = $config["apiclient"];

$apiClient = new HotelApiClient($cfgApi["url"],
    $cfgApi["apikey"],
    $cfgApi["sharedsecret"],
    new ApiVersion(ApiVersions::V1_0),
    $cfgApi["timeout"]);

$rateKey = urldecode($_GET['ratekey']);
//$rateKey = "20171115|20171120|W|1|1067|DBL.PI-VM|ID_B2B_24|RO|P02I|1~2~1|8|N@FC8ABF2716F445EAA624F87178024F011011";

$rqCheckRate = new \hotelbeds\hotel_api_sdk\helpers\CheckRate();
$rqCheckRate->rooms = [ [ "rateKey" => $rateKey ] ];

try {
    $CheckRateRS = $apiClient->CheckRate($rqCheckRate);

    echo "
    <style>
    table {border-collapse:collapse; table-layout:fixed; width:300px;}
   table td {border:solid 1px #c4e3f3; width:200px; word-wrap:break-word;}
    </style>
    ";
    echo "<b>CheckRates Raw Request <a href='https://developer.hotelbeds.com/docs/read/apitude_booking/CheckRates#request-parameters'>(View Documentation)</a></b><br>";
    echo "<pre>" . json_encode($rqCheckRate->toArray(), JSON_PRETTY_PRINT) . "</pre>";

    echo "<br><br>";

    echo "<b>CheckRates Response <a href='https://developer.hotelbeds.com/docs/read/apitude_booking/CheckRates#response-parameters'>(View Documentation)</a></b><br>";
    echo "<table border='1'>";
    echo "<tr><td>Room Code</td><td>Room Name</td><td>Net Price</td><td>Comments</td><td>Rate Key</td></tr>";
    echo "<tr><td>checkRateRS/hotel/rooms/room/@code</td>
    <td>checkRateRS/hotel/rooms/room/@name</td>
    <td>checkRateRS/hotel/rooms/room/rates/rate/@net</td>
    <td>checkRateRS/hotel/rooms/room/rates/rate/@rateComments</td>
    <td>checkRateRS/hotel/rooms/room/rates/rate/@rateKey</td></tr>";

    foreach ($CheckRateRS->hotel->iterator() as $hotelCode => $hotelData) {

        foreach ($hotelData->rateiterator() as $roomCode => $roomData) {
                echo "<tr>";
                echo '<td>'.$hotelData->code .'</td>';
                echo '<td>'.$hotelData->name .'</td>';
                echo '<td>'.$roomData->net.'</td>';
                echo '<td>'.$roomData->rateComments.'</td>';
                echo "<td><a href=booking.php?ratekey=" .urlencode($roomData->rateKey). ">$roomData->rateKey</a></td>";
                echo "</tr>";
        }
    };
    echo '</table><br><br>';

    echo "<b>CheckRates Raw Response <a href='https://developer.hotelbeds.com/docs/read/apitude_booking/CheckRates#response-parameters'>(View Documentation)</a></b><br>";
    echo "<pre>" . json_encode($CheckRateRS->hotel->toArray(), JSON_PRETTY_PRINT) . "</pre>";
}
 catch (\hotelbeds\hotel_api_sdk\types\HotelSDKException $e) {
    $auditData = $e->getAuditData();
    error_log( $e->getMessage() );
    error_log( "Audit remote data = ".json_encode($auditData->toArray()));
    exit();
} catch (Exception $e) {
    error_log( $e->getMessage() );
    exit();
}
