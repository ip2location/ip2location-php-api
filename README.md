# IP2Location PHP API

> This project has been merged into [IP2Location-PHP-Module](https://github.com/chrislim2888/IP2Location-PHP-Module). We will  no longer maintain and support this project. Please visit  [IP2Location-PHP-Module](https://github.com/chrislim2888/IP2Location-PHP-Module) for latest updates or enhancements.

This module allows user to geolocate the country, region, city, coordinates, zip code, ISP, domain name, timezone, connection speed, IDD code, area code, weather station code, weather station name, MCC, MNC, mobile brand name, elevation and usage type that any IP address or host name originates from by calling the **IP2Location API**.


## Getting Started
To begin, an API key is required for this module to function. Find further information at https://www.ip2location.com/web-service



## Usage

```php
<?php

require_once 'class.IP2LocationAPI.php';

$apiKey = 'YOUR_API_KEY';
$package = 'WS25'; // Package: WS1 - WS25
$useSSL = false; // Use HTTP or HTTPS (Secure, but slower)

$ip = '8.8.8.8';

// Initialize
$location = new IP2LocationAPI($apiKey, $package, $useSSL);

/*
Translate country, region, and city name to desired language.
Refer to product page for available language code.
*/
$location->setLanguage('zh-cn');

/*
Enable add ons to display more result.
Refer to product page for available add ons.
*/
$location->setAddOns([
	'continent', 'country', 'region', 'city', 'geotargeting', 'country_groupings', 'time_zone_info',
]);

// Start query
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
echo 'Usage Type           : ' . $location->usageType . "\n\n";
echo 'Address Type         : ' . $location->addressType . "\n\n";
echo 'Category             : ' . $location->category . "\n\n";

if ($location->continent) {
	echo 'Continent Name       : ' . $location->continent['name'] . "\n";
	echo 'Continent Code       : ' . $location->continent['code'] . "\n";
	echo 'Hemisphere           : ' . $location->continent['hemisphere'] . "\n";
	echo 'Localize Name        : ' . $location->continent['translated'] . "\n\n";
}

if ($location->country) {
	echo 'Country Name         : ' . $location->country['name'] . "\n";
	echo 'Localize Name        : ' . $location->country['translated'] . "\n";
	echo 'Alpha 3 Code         : ' . $location->country['alpha3Code'] . "\n";
	echo 'Numeric Code         : ' . $location->country['numericCode'] . "\n";
	echo 'Demonym              : ' . $location->country['demonym'] . "\n";
	echo 'Flag                 : ' . $location->country['flag'] . "\n";
	echo 'Capital              : ' . $location->country['capital'] . "\n";
	echo 'Total Area           : ' . $location->country['totalArea'] . "\n";
	echo 'Population           : ' . $location->country['population'] . "\n";
	echo 'Currency             : ' . $location->country['currencyName'] . ' (' . $location->country['currencyCode'] . ', ' . $location->country['currencySymbol'] . ')' . "\n";
	echo 'Language             : ' . $location->country['languageName'] . ' (' . $location->country['languageCode'] . ')' . "\n";
	echo 'IDD Code             : ' . $location->country['iddCode'] . "\n";
	echo 'TLD                  : ' . $location->country['tld'] . "\n\n";
}

if ($location->region) {
	echo 'Region Name          : ' . $location->region['name'] . "\n";
	echo 'Localize Name        : ' . $location->region['translated'] . "\n";
	echo 'Region Code          : ' . $location->region['code'] . "\n\n";
}

if ($location->city) {
	echo 'City Name            : ' . $location->city['name'] . "\n";
	echo 'Localize Name        : ' . $location->city['translated'] . "\n\n";
}

if ($location->geotargeting) {
	echo 'Metro Code           : ' . $location->geotargeting['metro'] . "\n\n";
}

if ($location->countryGroupings) {
	foreach ($location->countryGroupings as $group) {
		echo 'Group of             : ' . $group->name . ' (' . $group->acronym . ')' . "\n";
	}

	echo "\n";
}

if ($location->timeZoneInfo) {
	echo 'Olson                : ' . $location->timeZoneInfo['olson'] . "\n";
	echo 'Current Time         : ' . $location->timeZoneInfo['currentTime'] . "\n";
	echo 'GMT Offset           : ' . $location->timeZoneInfo['gmtOffset'] . "\n";
	echo 'DST                  : ' . $location->timeZoneInfo['isDST'] . "\n";
}

echo '</pre>';
```

