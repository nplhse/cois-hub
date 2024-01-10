<?php

namespace App\Form;

use App\Entity\DispatchArea;
use App\Entity\SupplyArea;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplyAreaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('dispatchArea', EntityType::class, [
                'class' => DispatchArea::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'disabled' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupplyArea::class,
        ]);
    }
}
