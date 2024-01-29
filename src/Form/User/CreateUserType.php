<?php

namespace App\Form\User;

use App\DataTransferObjects\UserAdminDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class)
            ->add('password', PasswordType::class, [
                'toggle' => true,
            ])
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Participant' => 'ROLE_PARTICIPANT',
                    'Admin' => 'ROLE_ADMIN',
                ],
            ])
            ->add('credentialsExpired', CheckboxType::class, [
                'required' => false,
                'value' => true,
                'label_attr' => [
                    'class' => 'checkbox-inline checkbox-switch',
                ],
            ])
            ->add('isVerified', CheckboxType::class, [
                'required' => false,
                'value' => true,
                'label_attr' => [
                    'class' => 'checkbox-inline checkbox-switch',
                ],
            ])
            ->add('isPublic', CheckboxType::class, [
                'required' => false,
                'value' => false,
                'label_attr' => [
                    'class' => 'checkbox-inline checkbox-switch',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAdminDTO::class,
        ]);
    }
}
