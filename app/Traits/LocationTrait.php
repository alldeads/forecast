<?php

namespace App\Traits;

use App\Traits\CurlTrait;

trait LocationTrait {

    use CurlTrait;

    public $accessToken = 'pjhrffEqD27l84J6rv-XBrJtANHq8Cm8ehGrwtF4JnCPh4rxIBCf_2CPkbEiCN1xAN8';

    public function getCountries()
    {
        $results = $this->sendRequest(null, "https://countriesnow.space/api/v0.1/countries/iso", 'get');

        if ( $results !== false ) {
            return $results['data'];
        }

        return [];
    }

    public function getCities($country)
    {
        $data = [
            "country" => strtolower($country)
        ];

        $results = $this->sendRequest($data, "https://countriesnow.space/api/v0.1/countries/cities", 'post');

        if ( $results !== false ) {
            return $results['data'];
        }

        return [];
    }
}