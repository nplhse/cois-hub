<?php

namespace App\Form\Hospital;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssociatedUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'choice_value' => 'id',
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('u')
                    ->orderBy('u.username', 'ASC'),
                'mapped' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
