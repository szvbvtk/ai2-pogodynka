<?php

namespace App\Controller;

use App\Entity\MeasurementEntry;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^[a-zA-Z-]+$/'])] string $city,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^[a-zA-Z]{2}$/'])] string $country,
        WeatherUtil $weatherUtil,
    ): JsonResponse {

        $city = str_replace('-', ' ', $city);
        $city = ucfirst($city);

        $measurementEntries = $weatherUtil->getWeatherForCountryAndCity($country, $city);

        return $this->json(
            [
                'city' => $city,
                'country' => $country,
                'measurements' => array_map(
                    fn(MeasurementEntry $m) => [
                        'temperature_celcius' => $m->getTemperatureCelcius(),
                        'feels_like' => $m->getFeelsLike(),
                        'humidity' => $m->getHumidity(),
                        'pressure' => $m->getPressure(),
                        'timestamp' => $m->getDateTime()->format('Y-m-d H:i:s'),
                        'wind_speed' => $m->getWindSpeed(),
                        'wind_direction' => $m->getWindDirection(),
                    ],
                    $measurementEntries
                ),
            ]
            );

}

}
