<?php

namespace App\Security\Voter;

use App\Entity\Hospital;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class HospitalVoter extends Voter
{
    final public const EDIT = 'HOSPITAL_EDIT';
    final public const VIEWSTATS = 'HOSPITAL_VIEWSTATS';
    final public const DELETE = 'HOSPITAL_DELETE';

    public function __construct(
        private readonly Security $security
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEWSTATS, self::DELETE])
            && $subject instanceof Hospital;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        /** @var Hospital $hospital */
        $hospital = $subject;

        return match ($attribute) {
            self::EDIT => $this->canEdit($hospital, $user),
            self::DELETE => $this->canDelete(),
            self::VIEWSTATS => $this->canViewStats($hospital, $user),
            default => throw new \LogicException('This code should not be reached!'),
        };
    }

    private function canEdit(Hospital $hospital, User $user): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return $user === $hospital->getOwner();
    }

    private function canDelete(): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return false;
    }

    private function canViewStats(Hospital $hospital, User $user): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($user === $hospital->getOwner()) {
            return true;
        }

        if ($hospital->getAssociatedUsers()->contains($user)) {
            return true;
        }

        return false;
    }
}
