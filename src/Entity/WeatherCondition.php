<?php

namespace App\Entity;

use App\Repository\WeatherConditionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherConditionRepository::class)]
class WeatherCondition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, MeasurementEntry>
     */
    #[ORM\ManyToMany(targetEntity: MeasurementEntry::class, mappedBy: 'weatherConditions')]
    private Collection $measurementEntries;

    public function __construct()
    {
        $this->measurementEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, MeasurementEntry>
     */
    public function getMeasurementEntries(): Collection
    {
        return $this->measurementEntries;
    }

    public function addMeasurementEntry(MeasurementEntry $measurementEntry): static
    {
        if (!$this->measurementEntries->contains($measurementEntry)) {
            $this->measurementEntries->add($measurementEntry);
            $measurementEntry->addWeatherCondition($this);
        }

        return $this;
    }

    public function removeMeasurementEntry(MeasurementEntry $measurementEntry): static
    {
        if ($this->measurementEntries->removeElement($measurementEntry)) {
            $measurementEntry->removeWeatherCondition($this);
        }

        return $this;
    }
}
