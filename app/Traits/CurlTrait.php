<?php

namespace App\Traits;

trait CurlTrait {

    public $open_weather_api = "https://api.openweathermap.org/data/2.5/weather?q=";
    public $weather_api_key  = "8daf100946aa4b7c85a141530211711";
    public $weather_api      = "https://api.weatherapi.com/v1/forecast.json";

    public function sendRequest($data, $endpoint, $method="post")
    {
        try {
            $curl = curl_init($endpoint);

            curl_setopt($curl, CURLOPT_URL, $endpoint);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
                "Accept: application/json",
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            if ( $method == "post") {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);

            return json_decode($resp, true);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function sendOpenWeatherRequest($params)
    {
        try {
            $params .= "&appId=4b5b8837f669a3a43355de3d067c9441"; 

            $endpoint = $this->open_weather_api . $params;

            $curl = curl_init($endpoint);

            curl_setopt($curl, CURLOPT_URL, $endpoint);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);

            return json_decode($resp, true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function sendWeatherRequest($params)
    {
        try {
            $params .= "&days=1&aqi=no&alerts=no"; 

            $endpoint = $this->weather_api . "?key={$this->weather_api_key}&q=" . $params;

            $curl = curl_init($endpoint);

            curl_setopt($curl, CURLOPT_URL, $endpoint);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);

            return json_decode($resp, true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}