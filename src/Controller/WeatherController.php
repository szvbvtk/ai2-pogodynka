<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Location;
use App\Repository\MeasurementEntryRepository;

class WeatherController extends AbstractController
{
    #[Route('/weather/{country}/{city}', name: 'app_weather', requirements: ['id' => '\d+'])]
    public function city(Location $location, MeasurementEntryRepository $measurementEntryRepository): Response
    {
        $measurementEntries = $measurementEntryRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurement_entries' => $measurementEntries,
        ]);

    }
}
