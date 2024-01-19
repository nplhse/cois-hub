<?php

namespace App\Message\Command\Hospital;

use App\Entity\Address;
use App\Entity\DispatchArea;
use App\Entity\State;
use App\Entity\SupplyArea;
use App\Entity\User;
use App\Enum\HospitalLocation;
use App\Enum\HospitalTier;

final readonly class UpdateHospital
{
    public function __construct(
        private int $hospitalId,
        private string $name,
        private User $owner,
        private int $beds,
        private HospitalLocation $location,
        private HospitalTier $tier,
        private Address $address,
        private State $state,
        private DispatchArea $dispatchArea,
        private ?SupplyArea $supplyArea,
    ) {
    }

    public function getHospitalId(): int
    {
        return $this->hospitalId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getBeds(): int
    {
        return $this->beds;
    }

    public function getLocation(): HospitalLocation
    {
        return $this->location;
    }

    public function getTier(): HospitalTier
    {
        return $this->tier;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function getDispatchArea(): DispatchArea
    {
        return $this->dispatchArea;
    }

    public function getSupplyArea(): ?SupplyArea
    {
        return $this->supplyArea;
    }
}
