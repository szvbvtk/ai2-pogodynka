<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\MeasurementEntry;
use App\Entity\WeatherCondition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MeasurementEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateTime', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date and Time',
                'attr' => [
                    'class' => 'form-control', // Dodanie klasy Bootstrap do stylizacji
                ],
            ])
            ->add('temperature_celcius', NumberType::class, [
                'label' => 'Temperature (°C)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter temperature in Celsius', // Placeholder dla wskazówki
                ],
            ])
            ->add('humidity', NumberType::class, [
                'label' => 'Humidity (%)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter humidity percentage',
                ],
            ])
            ->add('pressure', NumberType::class, [
                'label' => 'Pressure (hPa)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter pressure in hPa',
                ],
            ])
            ->add('wind_speed', NumberType::class, [
                'label' => 'Wind Speed (m/s)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter wind speed in m/s',
                ],
            ])
            ->add('wind_direction', ChoiceType::class, [
                'label' => 'Wind Direction',
                'choices' => [
                    'North' => 'N',
                    'Northeast' => 'NE',
                    'East' => 'E',
                    'Southeast' => 'SE',
                    'South' => 'S',
                    'Southwest' => 'SW',
                    'West' => 'W',
                    'Northwest' => 'NW',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('feels_like', NumberType::class, [
                'label' => 'Feels Like (°C)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter feels like temperature in Celsius',
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => function (Location $location) {
                    return $location->getCity() . ', ' . $location->getCountry(); // Łączenie miasta i kraju
                },
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('weatherConditions', EntityType::class, [
                'class' => WeatherCondition::class,
                'choice_label' => 'name', // Zmiana na bardziej opisowy label
                'multiple' => true,
                'attr' => [
                    'class' => 'form-select',
                ],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeasurementEntry::class,
        ]);
    }
}
