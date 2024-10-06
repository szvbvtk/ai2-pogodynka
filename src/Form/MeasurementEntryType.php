<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\MeasurementEntry;
use App\Entity\WeatherCondition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateTime', null, [
                'widget' => 'single_text',
            ])
            ->add('temperature_celcius')
            ->add('humidity')
            ->add('pressure')
            ->add('wind_speed')
            ->add('wind_direction')
            ->add('feels_like')
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
            ])
            ->add('weatherConditions', EntityType::class, [
                'class' => WeatherCondition::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MeasurementEntry::class,
        ]);
    }
}
