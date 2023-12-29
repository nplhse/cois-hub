<?php

namespace App\Form;

use App\DataTransferObjects\AccountSettingsTypeDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isPublic', CheckboxType::class, [
                'required' => false,
                'label' => 'Allow public access to your profile.',
                'label_attr' => [
                    'class' => 'checkbox-inline checkbox-switch',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccountSettingsTypeDTO::class,
        ]);
    }
}
