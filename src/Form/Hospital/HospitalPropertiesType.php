<?php

namespace App\Form\Hospital;

use App\Enum\HospitalLocation;
use App\Enum\HospitalTier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HospitalPropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('beds', IntegerType::class)
            ->add('location', EnumType::class, [
                'class' => HospitalLocation::class,
            ])
            ->add('tier', EnumType::class, [
                'class' => HospitalTier::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
