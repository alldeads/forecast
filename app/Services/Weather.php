<?php

namespace App\Services;

class Weather implements Service {

    private $endpoint = "https://api.weatherapi.com/v1/forecast.json";
    private $accessKey = "8daf100946aa4b7c85a141530211711";
    private $temperature;

    public function getForecastDetails($params)
    {
        $params = urlencode($params);

        try {
            $params .= "&days=1&aqi=no&alerts=no"; 

            $endpoint = $this->endpoint . "?key={$this->accessKey}&q=" . $params;

            $curl = curl_init($endpoint);

            curl_setopt($curl, CURLOPT_URL, $endpoint);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);

            $details = json_decode($resp, true);

            if ( isset($details['current']['temp_c']) ) {
                $this->temperature = $details['current']['temp_c'];
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getTemperature()
    {
        return $this->temperature;
    }
}