<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use App\Repository\MeasurementEntryRepository;

class WeatherUtil
{
    public function __construct(
        private MeasurementEntryRepository $measurementEntryRepository,
        private LocationRepository $locationRepository,
    ) {}

    /**
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->measurementEntryRepository->findByLocation($location);
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $city = str_replace('-', ' ', $city);
        $city = ucfirst($city);

        $location = null;
        if ($countryCode) {
            $countryCode = strtoupper($countryCode);

            $location = $this->locationRepository->findOneByCityAndCountry($city, $countryCode);
        }else {
            $location = $this->locationRepository->findOneByCity($city);
        }

        return $this->getWeatherForLocation($location);
    }
}
