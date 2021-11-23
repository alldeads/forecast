<?php

namespace App\Services;

interface Service {
    public function getForecastDetails($params);
    public function getTemperature();
}