<?php

namespace App\Form\Hospital;

use App\Entity\DispatchArea;
use App\Entity\State;
use App\Entity\SupplyArea;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HospitalBasicsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('state', EntityType::class, [
                'class' => State::class,
            ])
            ->add('dispatchArea', EntityType::class, [
                'class' => DispatchArea::class,
            ])
            ->add('supplyArea', EntityType::class, [
                'class' => SupplyArea::class,
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
