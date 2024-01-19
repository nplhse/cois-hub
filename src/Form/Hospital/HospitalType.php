<?php

namespace App\Form\Hospital;

use App\Entity\DispatchArea;
use App\Entity\Hospital;
use App\Entity\State;
use App\Entity\SupplyArea;
use App\Entity\User;
use App\Enum\HospitalLocation;
use App\Enum\HospitalTier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HospitalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('beds', IntegerType::class)
            ->add('location', EnumType::class, [
                'class' => HospitalLocation::class,
            ])
            ->add('address', AddressType::class)
            ->add('tier', EnumType::class, [
                'class' => HospitalTier::class,
            ])
            ->add('owner', EntityType::class, [
                'class' => User::class,
            ])
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
            'data_class' => Hospital::class,
        ]);
    }
}
