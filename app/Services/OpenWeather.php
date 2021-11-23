<?php

namespace App\Services;

class OpenWeather implements Service {

    private $endpoint = "https://api.openweathermap.org/data/2.5/weather?q=";
    private $temperature;

    public function getForecastDetails($params)
    {
        $params = urlencode($params);

        try {
            $params .= "&appId=4b5b8837f669a3a43355de3d067c9441"; 

            $endpoint = $this->endpoint . $params;

            $curl = curl_init($endpoint);

            curl_setopt($curl, CURLOPT_URL, $endpoint);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);

            $details = json_decode($resp, true);
            
            if ( isset($details['main']['temp']) ) {
                $this->temperature = $details['main']['temp'];
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getTemperature()
    {
        return $this->temperature ? $this->temperature - 273.15 : null;
    }
}