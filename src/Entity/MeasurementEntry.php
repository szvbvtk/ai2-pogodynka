<?php

namespace App\Entity;

use App\Repository\MeasurementEntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementEntryRepository::class)]
class MeasurementEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'measurementEntries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTime = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $temperature_celcius = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $humidity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 1)]
    private ?string $pressure = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $wind_speed = null;

    #[ORM\Column(length: 3)]
    private ?string $wind_direction = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $feels_like = null;

    /**
     * @var Collection<int, WeatherCondition>
     */
    #[ORM\ManyToMany(targetEntity: WeatherCondition::class, inversedBy: 'measurementEntries')]
    private Collection $weatherConditions;

    public function __construct()
    {
        $this->weatherConditions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getTemperatureCelcius(): ?string
    {
        return $this->temperature_celcius;
    }

    public function setTemperatureCelcius(string $temperature_celcius): static
    {
        $this->temperature_celcius = $temperature_celcius;

        return $this;
    }

    public function getFahrenheit(): ?string
    {
        $fahrenheit = number_format((($this->temperature_celcius * 9 / 5) + 32), 2);
        return $fahrenheit;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(string $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getPressure(): ?string
    {
        return $this->pressure;
    }

    public function setPressure(string $pressure): static
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getWindSpeed(): ?string
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(string $wind_speed): static
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function getWindDirection(): ?string
    {
        return $this->wind_direction;
    }

    public function setWindDirection(string $wind_direction): static
    {
        $this->wind_direction = $wind_direction;

        return $this;
    }

    public function getFeelsLike(): ?string
    {
        return $this->feels_like;
    }

    public function setFeelsLike(string $feels_like): static
    {
        $this->feels_like = $feels_like;

        return $this;
    }

    /**
     * @return Collection<int, WeatherCondition>
     */
    public function getWeatherConditions(): Collection
    {
        return $this->weatherConditions;
    }

    public function addWeatherCondition(WeatherCondition $weatherCondition): static
    {
        if (!$this->weatherConditions->contains($weatherCondition)) {
            $this->weatherConditions->add($weatherCondition);
        }

        return $this;
    }

    public function removeWeatherCondition(WeatherCondition $weatherCondition): static
    {
        $this->weatherConditions->removeElement($weatherCondition);

        return $this;
    }
}
