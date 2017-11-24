<?php

require_once 'class.IP2LocationAPI.php';

$apiKey = 'YOUR_API_KEY';
$package = 'WS24'; // Package: WS1 - WS24
$useSSL = false; // Use HTTP or HTTPS (Secure, but slower)

$ip = '8.8.8.8';

$location = new IP2LocationAPI($apiKey, $package, $useSSL);

if (!$location->query($ip)) {
	die('ERROR');
}

echo '<pre>';
echo 'Country Code         : ' . $location->countryCode . "\n";
echo 'Country Name         : ' . $location->countryName . "\n";
echo 'Region Name          : ' . $location->regionName . "\n";
echo 'City Name            : ' . $location->cityName . "\n";
echo 'Latitude             : ' . $location->latitude . "\n";
echo 'Longitude            : ' . $location->longitude . "\n";
echo 'ZIP Code             : ' . $location->zipCode . "\n";
echo 'Time Zone            : ' . $location->timeZone . "\n";
echo 'ISP                  : ' . $location->isp . "\n";
echo 'Domain               : ' . $location->domain . "\n";
echo 'Latitude             : ' . $location->netSpeed . "\n";
echo 'IDD Code             : ' . $location->iddCode . "\n";
echo 'Area Code            : ' . $location->areaCode . "\n";
echo 'Weather Station Code : ' . $location->weatherStationCode . "\n";
echo 'Weather Station Name : ' . $location->weatherStationName . "\n";
echo 'Mobile Brand         : ' . $location->mobileBrand . "\n";
echo 'Elevation            : ' . $location->elevation . "\n";
echo 'Usage Type           : ' . $location->usageType . "\n";
echo '</pre>';
