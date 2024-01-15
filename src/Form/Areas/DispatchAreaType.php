<?php

namespace App\Form\Areas;

use App\Entity\DispatchArea;
use App\Entity\State;
use App\Entity\SupplyArea;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DispatchAreaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('state', EntityType::class, [
                'class' => State::class,
                'choice_label' => 'name',
            ])
            ->add('supplyArea', EntityType::class, [
                'class' => SupplyArea::class,
                'choice_label' => 'name',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DispatchArea::class,
        ]);
    }
}
