<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\LocationRepository;
use App\Repository\MeasurementEntryRepository;
use App\Service\WeatherUtil;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

class WeatherController extends AbstractController
{

    #[Route('/weather/{city}/{country?}', name: 'app_weather', requirements: ['city' => '[a-zA-Z-]+', 'country' => '[a-zA-Z]{2}'])]
    public function city( 
        // #[MapEntity(mapping: ['city' => 'city', 'country' => 'country'])]
        // Location $location,
        string $city, 
        ?string $country,
        WeatherUtil $weatherUtil,
        LocationRepository $locationRepository,
        ): Response
    {
        $city = str_replace('-', ' ', $city);
        $city = ucfirst($city);

        $location = null;
        if ($country) {
            $country = strtoupper($country);

            $location = $locationRepository->findOneByCityAndCountry($city, $country);
        }else {
            $location = $locationRepository->findOneByCity($city);
        }

        $measurementEntries = $weatherUtil->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurement_entries' => $measurementEntries,
        ]);

    }
}
