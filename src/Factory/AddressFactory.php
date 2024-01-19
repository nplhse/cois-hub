<?php

namespace App\Factory;

use App\Entity\Address;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Address>
 *
 * @method        Address|Proxy     create(array|callable $attributes = [])
 * @method static Address|Proxy     createOne(array $attributes = [])
 * @method static Address[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Address[]|Proxy[] createSequence(iterable|callable $sequence)
 *
 * @phpstan-method        Proxy<Address> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Address> createOne(array $attributes = [])
 * @phpstan-method static list<Proxy<Address>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Address>> createSequence(iterable|callable $sequence)
 */
final class AddressFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'city' => self::faker()->city(),
            'state' => \Faker\Provider\de_DE\Address::state(),
            'country' => 'Deutschland',
            'postalCode' => self::faker()->postcode(),
            'street' => self::faker()->streetAddress(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->withoutPersisting()
            // ->afterInstantiate(function(Address $address): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Address::class;
    }
}
