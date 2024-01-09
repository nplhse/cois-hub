<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CookieConsentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('target', HiddenType::class)
            ->add('allowAll', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-primary',
                    'data-bs-dismiss' => 'offcanvas',
                ],
                'label' => 'label.cookie_allow_all',
            ])
            ->add('allowEssential', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                    'data-bs-dismiss' => 'offcanvas',
                ],
                'label' => 'label.cookie_allow_essential',
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
