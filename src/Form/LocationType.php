<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'attr' => ['placeholder' => 'Enter city name', 'autofocus' => true],
            ])
            ->add('latitude', NumberType::class, [
                // doc - If set to true, the HTML input will be rendered as a native HTML5 type="number" form. 
                'html5' => true,
                'scale' => 6,
            ])
            ->add('longitude', NumberType::class, [
                'html5' => true,
                'scale' => 7,
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Poland' => 'PL',
                    'Italy' => 'IT',
                    'Germany' => 'DE',
                    'France' => 'FR',
                    'Canada' => 'CA',
                    'Spain' => 'ES',
                    'China' => 'CN',
                    'Russia' => 'RU',
                    'United States' => 'US',
                    'Japan' => 'JP',
                    'United Kingdom' => 'GB',
                    'Australia' => 'AU',
                    'Brazil' => 'BR',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
