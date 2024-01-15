<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Address
{
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING)]
    private string $street;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING)]
    private string $postalCode;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING)]
    private string $city;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING)]
    private string $state;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING)]
    private string $country;

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}
