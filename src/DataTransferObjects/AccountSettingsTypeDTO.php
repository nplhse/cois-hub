<?php

namespace App\DataTransferObjects;

class AccountSettingsTypeDTO
{
    private bool $isPublic = false;

    public function getIsPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }
}
