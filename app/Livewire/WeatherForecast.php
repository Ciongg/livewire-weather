<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class WeatherForecast extends Component
{

       public $weatherData = [];
    public $loading = true;
    public $error = null;

    public function mount()
    {
        $this->fetchWeather();
    }

    public function fetchWeather()
    {
        try {
            $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => 14.625,
                'longitude' => 121,
                'daily' => 'weather_code,temperature_2m_max,temperature_2m_min,sunrise,sunset,precipitation_sum,precipitation_probability_max,wind_speed_10m_max,daylight_duration,sunshine_duration',
                'timezone' => 'Asia/Manila'
            ]);

            if (!$response->successful()) {
                throw new \Exception('Error fetching weather data');
            }

            $data = $response->json();
            
            $this->weatherData = collect($data['daily']['time'])->map(function ($time, $index) use ($data) {
                return [
                    'time' => $time,
                    'weather_code' => $data['daily']['weather_code'][$index],
                    'temperature_2m_max' => $data['daily']['temperature_2m_max'][$index],
                    'temperature_2m_min' => $data['daily']['temperature_2m_min'][$index],
                    'precipitation_sum' => $data['daily']['precipitation_sum'][$index],
                    'precipitation_probability_max' => $data['daily']['precipitation_probability_max'][$index],
                    'wind_speed_10m_max' => $data['daily']['wind_speed_10m_max'][$index],
                    'sunrise' => $data['daily']['sunrise'][$index],
                    'sunset' => $data['daily']['sunset'][$index],
                ];
            })->toArray();

            $this->loading = false;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->loading = false;
        }
    }

    public function getWeatherIcon($code)
    {
        // Map weather codes to icons or descriptions
        $weatherMapping = [
            0 => ['icon' => '☀️', 'description' => 'Clear sky'],
            1 => ['icon' => '🌤️', 'description' => 'Mainly clear'],
            2 => ['icon' => '⛅', 'description' => 'Partly cloudy'],
            3 => ['icon' => '☁️', 'description' => 'Overcast'],
            45 => ['icon' => '🌫️', 'description' => 'Fog'],
            48 => ['icon' => '🌫️', 'description' => 'Depositing rime fog'],
            51 => ['icon' => '🌧️', 'description' => 'Light drizzle'],
            53 => ['icon' => '🌧️', 'description' => 'Moderate drizzle'],
            55 => ['icon' => '🌧️', 'description' => 'Dense drizzle'],
            56 => ['icon' => '🌧️', 'description' => 'Light freezing drizzle'],
            57 => ['icon' => '🌧️', 'description' => 'Dense freezing drizzle'],
            61 => ['icon' => '🌧️', 'description' => 'Slight rain'],
            63 => ['icon' => '🌧️', 'description' => 'Moderate rain'],
            65 => ['icon' => '🌧️', 'description' => 'Heavy rain'],
            66 => ['icon' => '🌧️', 'description' => 'Light freezing rain'],
            67 => ['icon' => '🌧️', 'description' => 'Heavy freezing rain'],
            71 => ['icon' => '❄️', 'description' => 'Slight snow fall'],
            73 => ['icon' => '❄️', 'description' => 'Moderate snow fall'],
            75 => ['icon' => '❄️', 'description' => 'Heavy snow fall'],
            77 => ['icon' => '❄️', 'description' => 'Snow grains'],
            80 => ['icon' => '🌧️', 'description' => 'Slight rain showers'],
            81 => ['icon' => '🌧️', 'description' => 'Moderate rain showers'],
            82 => ['icon' => '🌧️', 'description' => 'Violent rain showers'],
            85 => ['icon' => '❄️', 'description' => 'Slight snow showers'],
            86 => ['icon' => '❄️', 'description' => 'Heavy snow showers'],
            95 => ['icon' => '⛈️', 'description' => 'Thunderstorm'],
            96 => ['icon' => '⛈️', 'description' => 'Thunderstorm with slight hail'],
            99 => ['icon' => '⛈️', 'description' => 'Thunderstorm with heavy hail'],
        ];

        return $weatherMapping[$code] ?? ['icon' => '❓', 'description' => 'Unknown'];
    }


    public function render()
    {
        return view('livewire.weather-forecast');
    }
}



// <?php

// namespace App\Livewire;

// use Illuminate\Support\Facades\Http;
// use Livewire\Component;

// class WeatherForecast extends Component
// {
//     public $weatherData = [];
//     public $loading = true;
//     public $error = null;

//     public function mount()
//     {
//         $this->fetchWeather();
//     }

//     public function fetchWeather()
//     {
//         try {
//             $response = Http::get('https://api.open-meteo.com/v1/forecast', [
//                 'latitude' => 14.625,
//                 'longitude' => 121,
//                 'daily' => 'weather_code,temperature_2m_max,temperature_2m_min,sunrise,sunset,precipitation_sum,precipitation_probability_max,wind_speed_10m_max,daylight_duration,sunshine_duration',
//                 'timezone' => 'Asia/Manila'
//             ]);

//             if (!$response->successful()) {
//                 throw new \Exception('Error fetching weather data');
//             }

//             $data = $response->json();
            
//             $this->weatherData = collect($data['daily']['time'])->map(function ($time, $index) use ($data) {
//                 return [
//                     'time' => $time,
//                     'weather_code' => $data['daily']['weather_code'][$index],
//                     'temperature_2m_max' => $data['daily']['temperature_2m_max'][$index],
//                     'temperature_2m_min' => $data['daily']['temperature_2m_min'][$index],
//                     'precipitation_sum' => $data['daily']['precipitation_sum'][$index],
//                     'precipitation_probability_max' => $data['daily']['precipitation_probability_max'][$index],
//                     'wind_speed_10m_max' => $data['daily']['wind_speed_10m_max'][$index],
//                     'sunrise' => $data['daily']['sunrise'][$index],
//                     'sunset' => $data['daily']['sunset'][$index],
//                 ];
//             })->toArray();

//             $this->loading = false;
//         } catch (\Exception $e) {
//             $this->error = $e->getMessage();
//             $this->loading = false;
//         }
//     }

//     public function getWeatherIcon($code)
//     {
//         // Map weather codes to icons or descriptions
//         $weatherMapping = [
//             0 => ['icon' => '☀️', 'description' => 'Clear sky'],
//             1 => ['icon' => '🌤️', 'description' => 'Mainly clear'],
//             2 => ['icon' => '⛅', 'description' => 'Partly cloudy'],
//             3 => ['icon' => '☁️', 'description' => 'Overcast'],
//             45 => ['icon' => '🌫️', 'description' => 'Fog'],
//             48 => ['icon' => '🌫️', 'description' => 'Depositing rime fog'],
//             51 => ['icon' => '🌧️', 'description' => 'Light drizzle'],
//             53 => ['icon' => '🌧️', 'description' => 'Moderate drizzle'],
//             55 => ['icon' => '🌧️', 'description' => 'Dense drizzle'],
//             56 => ['icon' => '🌧️', 'description' => 'Light freezing drizzle'],
//             57 => ['icon' => '🌧️', 'description' => 'Dense freezing drizzle'],
//             61 => ['icon' => '🌧️', 'description' => 'Slight rain'],
//             63 => ['icon' => '🌧️', 'description' => 'Moderate rain'],
//             65 => ['icon' => '🌧️', 'description' => 'Heavy rain'],
//             66 => ['icon' => '🌧️', 'description' => 'Light freezing rain'],
//             67 => ['icon' => '🌧️', 'description' => 'Heavy freezing rain'],
//             71 => ['icon' => '❄️', 'description' => 'Slight snow fall'],
//             73 => ['icon' => '❄️', 'description' => 'Moderate snow fall'],
//             75 => ['icon' => '❄️', 'description' => 'Heavy snow fall'],
//             77 => ['icon' => '❄️', 'description' => 'Snow grains'],
//             80 => ['icon' => '🌧️', 'description' => 'Slight rain showers'],
//             81 => ['icon' => '🌧️', 'description' => 'Moderate rain showers'],
//             82 => ['icon' => '🌧️', 'description' => 'Violent rain showers'],
//             85 => ['icon' => '❄️', 'description' => 'Slight snow showers'],
//             86 => ['icon' => '❄️', 'description' => 'Heavy snow showers'],
//             95 => ['icon' => '⛈️', 'description' => 'Thunderstorm'],
//             96 => ['icon' => '⛈️', 'description' => 'Thunderstorm with slight hail'],
//             99 => ['icon' => '⛈️', 'description' => 'Thunderstorm with heavy hail'],
//         ];

//         return $weatherMapping[$code] ?? ['icon' => '❓', 'description' => 'Unknown'];
//     }

//     public function render()
//     {
//         return view('livewire.weather-forecast');
//     }
// }
