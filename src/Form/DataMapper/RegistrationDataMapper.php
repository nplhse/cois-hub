<?php

namespace App\Form\DataMapper;

use App\DataTransferObjects\RegisterTypeDTO;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormInterface;

final class RegistrationDataMapper implements DataMapperInterface
{
    /**
     * @param RegisterTypeDTO              $viewData
     * @param FormInterface[]|\Traversable $forms
     */
    public function mapDataToForms($viewData, $forms): void
    {
        if (null !== $viewData) {
            $forms = iterator_to_array($forms);
            $forms['username']->setData($viewData->getUsername());
            $forms['email']->setData($viewData->getEmail());
        }
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param RegisterTypeDTO              $viewData
     */
    public function mapFormsToData($forms, &$viewData): void
    {
        $forms = iterator_to_array($forms);

        $viewData->setUsername($forms['username']->getData());
        $viewData->setEmail($forms['email']->getData());

        if ($forms['password']['first']->getData() === $forms['password']['second']->getData()) {
            $viewData->setPassword($forms['password']['first']->getData());
        }
    }
}
