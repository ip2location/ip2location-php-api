<?php

class IP2LocationAPI
{
	public $countryCode;
	public $countryName;
	public $regionName;
	public $cityName;
	public $latitude;
	public $longitude;
	public $zipCode;
	public $isp;
	public $domain;
	public $timeZone;
	public $netSpeed;
	public $iddCode;
	public $areaCode;
	public $weatherStationCode;
	public $weatherStationName;
	public $mcc;
	public $mnc;
	public $mobileBrand;
	public $elevation;
	public $usageType;

	public $continent = [
		'name'       => '',
		'translated' => '',
		'code'       => '',
		'hemisphere' => '',
	];

	public $country = [
		'name'           => '',
		'translated'     => '',
		'alpha3Code'     => '',
		'numericCode'    => '',
		'demonym'        => '',
		'flag'           => '',
		'capital'        => '',
		'totalArea'      => '',
		'population'     => '',
		'currencyCode'   => '',
		'currencyName'   => '',
		'currencySymbol' => '',
		'languageCode'   => '',
		'languageName'   => '',
		'iddCode'        => '',
		'tld'            => '',
	];

	public $region = [
		'name'       => '',
		'translated' => '',
		'code'       => '',
	];

	public $city = [
		'name'       => '',
		'translated' => '',
	];

	public $geotageting = [
		'metro' => '',
	];

	public $countryGroupings = [];

	public $timeZoneInfo = [
		'olson'       => '',
		'currentTime' => '',
		'gmtOffset'   => '',
		'isDST'       => '',
	];

	protected $apiKey;
	protected $package;
	protected $useSSL;

	private $options = [
		'language' => 'en',
		'addOns'   => '',
	];

	public function __construct($apiKey = '', $package = 'WS24', $useSSL = false)
	{
		$this->apiKey = $apiKey;
		$this->package = $package;
		$this->useSSL = $useSSL;
	}

	public function setLanguage($code)
	{
		if (!in_array($code, ['ar', 'cs', 'da', 'de', 'en', 'es', 'et', 'fi', 'fr', 'ga', 'it', 'ja', 'ko', 'ms', 'nl', 'pt', 'ru', 'sv', 'tr', 'vi', 'zh-cn', 'zh-tw'])) {
			throw new Exception('Invalid language code.');
		}

		$this->options['language'] = $code;
	}

	public function setAddOns($addOns)
	{
		if (!is_array($addOns)) {
			throw new Exception('Please add in addons as array.');
		}

		foreach ($addOns as $addOn) {
			if (!in_array($addOn, ['continent', 'country', 'region', 'city', 'geotargeting', 'country_groupings', 'time_zone_info'])) {
				throw new Exception('Invalid addon "' . $addOn . '".');
			}
		}

		$this->options['addOns'] = implode(',', $addOns);
	}

	public function query($ip)
	{
		if (!filter_var($ip, FILTER_VALIDATE_IP)) {
			return false;
		}

		$response = $this->get('http' . (($this->useSSL) ? 's' : '') . '://api.ip2location.com/v2/?' . http_build_query([
			'key'     => $this->apiKey,
			'ip'      => $ip,
			'package' => $this->package,
			'format'  => 'json',
			'lang'    => $this->options['language'],
			'addon'   => $this->options['addOns'],
		]));

		if (($json = json_decode($response)) === null) {
			return false;
		}

		if (isset($json->response)) {
			return false;
		}

		$this->countryCode = (string) (isset($json->country_code)) ? $json->country_code : 'N/A';
		$this->countryName = (string) (isset($json->country_name)) ? $json->country_name : 'N/A';
		$this->regionName = (string) (isset($json->region_name)) ? $json->region_name : 'N/A';
		$this->cityName = (string) (isset($json->city_name)) ? $json->city_name : 'N/A';
		$this->latitude = (float) (isset($json->latitude)) ? $json->latitude : 'N/A';
		$this->longitude = (float) (isset($json->longitude)) ? $json->longitude : 'N/A';
		$this->zipCode = (string) (isset($json->zip_code)) ? $json->zip_code : 'N/A';
		$this->timeZone = (string) (isset($json->time_zone)) ? $json->time_zone : 'N/A';
		$this->isp = (string) (isset($json->isp)) ? $json->isp : 'N/A';
		$this->domain = (string) (isset($json->domain)) ? $json->domain : 'N/A';
		$this->netSpeed = (string) (isset($json->net_speed)) ? $json->net_speed : 'N/A';
		$this->iddCode = (string) (isset($json->idd_code)) ? $json->idd_code : 'N/A';
		$this->areaCode = (string) (isset($json->area_code)) ? $json->area_code : 'N/A';
		$this->weatherStationCode = (string) (isset($json->weather_station_code)) ? $json->weather_station_code : 'N/A';
		$this->weatherStationName = (string) (isset($json->weather_station_name)) ? $json->weather_station_name : 'N/A';
		$this->mcc = (string) (isset($json->mcc)) ? $json->mcc : 'N/A';
		$this->mnc = (string) (isset($json->mnc)) ? $json->mnc : 'N/A';
		$this->mobileBrand = (string) (isset($json->mobile_brand)) ? $json->mobile_brand : 'N/A';
		$this->elevation = (int) (isset($json->elevation)) ? $json->elevation : 'N/A';
		$this->usageType = (string) (isset($json->usage_type)) ? $json->usage_type : 'N/A';

		if (isset($json->continent)) {
			$this->continent = [
				'name'       => $json->continent->name,
				'code'       => $json->continent->code,
				'translated' => $json->continent->translations->{$this->options['language']},
				'hemisphere' => $json->continent->hemisphere[0] . ',' . $json->continent->hemisphere[1],
			];
		}

		if (isset($json->country)) {
			$this->country = [
				'name'           => $json->country->name,
				'translated'     => $json->country->translations->{$this->options['language']},
				'alpha3Code'     => $json->country->alpha3_code,
				'numericCode'    => $json->country->numeric_code,
				'demonym'        => $json->country->demonym,
				'flag'           => $json->country->flag,
				'capital'        => $json->country->capital,
				'totalArea'      => $json->country->total_area,
				'population'     => $json->country->population,
				'currencyCode'   => $json->country->currency->code,
				'currencyName'   => $json->country->currency->name,
				'currencySymbol' => $json->country->currency->symbol,
				'languageCode'   => $json->country->language->code,
				'languageName'   => $json->country->language->name,
				'iddCode'        => $json->country->idd_code,
				'tld'            => $json->country->tld,
			];
		}

		if (isset($json->region)) {
			$this->region = [
				'name'       => $json->region->name,
				'translated' => $json->region->translations->{$this->options['language']},
				'code'       => $json->region->code,
			];
		}

		if (isset($json->city)) {
			$this->city = [
				'name'       => $json->city->name,
				'translated' => (isset($json->city->translations->{$this->options['language']})) ? $json->city->translations->{$this->options['language']} : $json->city->name,
			];
		}

		if (isset($json->geotargeting)) {
			$this->geotargeting = [
				'metro' => $json->geotargeting->metro,
			];
		}

		if (isset($json->country_groupings)) {
			$this->countryGroupings = $json->country_groupings;
		}

		if (isset($json->time_zone_info)) {
			$this->timeZoneInfo = [
				'olson'       => $json->time_zone_info->olson,
				'currentTime' => $json->time_zone_info->current_time,
				'gmtOffset'   => $json->time_zone_info->gmt_offset,
				'isDST'       => $json->time_zone_info->is_dst,
			];
		}

		return true;
	}

	private function get($url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'IP2LocationAPI_PHP-1.1.0');
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$response = curl_exec($ch);

		return $response;
	}
}
