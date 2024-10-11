<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'weather:CityCountry',
    description: 'Add a short description for your command',
)]
class WeatherCityCountryCommand extends Command
{
    public function __construct(
        private WeatherUtil $weatherUtil,
        private LocationRepository $locationRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Get the weather for a city and country')
            ->setHelp('This command allows you to get the weather for a city and country')
            ->addArgument('city', InputArgument::REQUIRED, 'City')
            ->addArgument('country', InputArgument::OPTIONAL, 'Country')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $city = $input->getArgument('city');
        $country = $input->getArgument('country');

        $city = str_replace('-', ' ', $city);
        $city = ucfirst($city);

        $location = null;
        if ($country) {
            $country = strtoupper($country);

            $location = $this->locationRepository->findOneByCityAndCountry($city, $country);
        } else {
            $location = $this->locationRepository->findOneByCity($city);
        }

        if (!$location) {
            $io->error('Location not found');
            return Command::FAILURE;
        }

        $measurementEntries = $this->weatherUtil->getWeatherForLocation($location);

        if (empty($measurementEntries)) {
            $io->error('No weather data found for location');
            return Command::FAILURE;
        }

        $io->success('Weather data for location: ' . $location->getCity() . ', ' . $location->getCountry());
        $io->table(
            ['Date', 'Temperature', 'Feels like', 'Humidity', 'Pressure', 'Wind Speed', 'Wind Direction'],
            array_map(function ($measurementEntry) {
                return [$measurementEntry->getDateTime()->format('Y-m-d H:i:s'), $measurementEntry->getTemperatureCelcius(), $measurementEntry->getFeelsLike(),
                    $measurementEntry->getHumidity(), $measurementEntry->getPressure(), $measurementEntry->getWindSpeed(), $measurementEntry->getWindDirection()];
            }, $measurementEntries)
        );


        return Command::SUCCESS;
    }
}
