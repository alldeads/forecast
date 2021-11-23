<?php

namespace App\Http\Livewire;

use App\Traits\LocationTrait;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use App\Models\Weather;
use App\Services\OpenWeather;
use App\Services\Weather as WeatherAPI;

class Forecast extends Component
{
    use LocationTrait;

    public $inputs = [
        'country',
        'city'
    ];

    public $countries;
    public $avg;

    public function mount()
    {
        $this->countries = $this->getCountries();
        $this->cities    = [];
        $this->avg       = 0;
    }

    public function updated($key, $value)
    {
        if ( $key == "inputs.country" ) {
            $str = explode('---', $value);

            $this->cities = $this->getCities($str[1] ?? '');
        }
    }

    public function submit()
    {
        $validator = Validator::make($this->inputs, [
            'country'   => ['required', 'string', 'max:255'],
            'city'      => ['required', 'string', 'max:255'],
        ])->validate();

        $country = explode('---', $this->inputs['country']);

        $iso    = $country[0];
        $params = $this->inputs['city'] . ',' . $iso;

        $open_weather = new OpenWeather();
        $weather      = new WeatherAPI();

        $open_weather->getForecastDetails($params);
        $weather->getForecastDetails($this->inputs['city']);

        $x = $open_weather->getTemperature();
        $y = $weather->getTemperature();

        if ( $x && $y  ) {

            $forecast_1 = $x;
            $forecast_2 = $y;

            $this->avg  = $this->calculate($forecast_1, $forecast_2);

            Weather::create([
                'city'         => $this->inputs['city'],
                'country'      => $country[1] ?? "",
                'forecast_1'   => $forecast_1,
                'forecast_2'   => $forecast_2,
                'avg_forecast' => $this->avg
            ]);
        } else {
            $this->avg = "Sorry, we couldn't find what you are looking for. Please try again.";
        }
    }

    public function calculate($x, $y)
    {
        return ($x + $y) / 2;
    }

    public function render()
    {
        return view('livewire.forecast');
    }
}
