<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENWEATHER_API_KEY');
    }

    public function getWeatherByCoords($lat, $lon)
    {
        $cacheKey = "weather_{$lat}_{$lon}";
        dd($this->apiKey);
        return Cache::remember($cacheKey, now()->addHour(), function() use ($lat, $lon) {
            try {
                $response = $this->client->get('https://api.openweathermap.org/data/2.5/weather', [
                    'query' => [
                        'lat' => $lat,
                        'lon' => $lon,
                        'appid' => $this->apiKey,
                        'units' => 'metric',
                        'lang' => 'ar'
                    ]
                ]);
    
                return json_decode($response->getBody(), true);
            } catch (\Exception $e) {
                \Log::error('Weather API Error: ' . $e->getMessage());
                return null;
            }
        });
    }
}