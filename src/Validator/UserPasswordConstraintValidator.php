<?php

// src/Validator/ContainsAlphanumericValidator.php

namespace App\Validator;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UserPasswordConstraintValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly Security $security,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UserPasswordConstraint) {
            throw new UnexpectedTypeException($constraint, UserPasswordConstraint::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        /** @var User $user */
        $user = $this->security->getUser();

        if ($this->userPasswordHasher->isPasswordValid($user, $value)) {
            return;
        }

        // the argument must be a string or an object implementing __toString()
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}
