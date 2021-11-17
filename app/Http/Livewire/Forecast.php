<?php

namespace App\Http\Livewire;

use App\Traits\LocationTrait;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use App\Models\Weather;

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

        $results = $this->sendOpenWeatherRequest(urlencode($params));
        $weather = $this->sendWeatherRequest(urlencode($this->inputs['city']));

        if ( isset($results['main']['temp']) && isset($weather['current']['temp_c']) ) {

            $forecast_1 = $results['main']['temp'] - 273.15;
            $forecast_2 = $weather['current']['temp_c'];
            $this->avg  = ($forecast_1 + $forecast_2) / 2;

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

    public function render()
    {
        return view('livewire.forecast');
    }
}
