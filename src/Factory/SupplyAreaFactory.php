<?php

namespace App\Factory;

use App\Entity\SupplyArea;
use App\Repository\SupplyAreaRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<SupplyArea>
 *
 * @method        SupplyArea|Proxy                     create(array|callable $attributes = [])
 * @method static SupplyArea|Proxy                     createOne(array $attributes = [])
 * @method static SupplyArea|Proxy                     find(object|array|mixed $criteria)
 * @method static SupplyArea|Proxy                     findOrCreate(array $attributes)
 * @method static SupplyArea|Proxy                     first(string $sortedField = 'id')
 * @method static SupplyArea|Proxy                     last(string $sortedField = 'id')
 * @method static SupplyArea|Proxy                     random(array $attributes = [])
 * @method static SupplyArea|Proxy                     randomOrCreate(array $attributes = [])
 * @method static SupplyAreaRepository|RepositoryProxy repository()
 * @method static SupplyArea[]|Proxy[]                 all()
 * @method static SupplyArea[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static SupplyArea[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static SupplyArea[]|Proxy[]                 findBy(array $attributes)
 * @method static SupplyArea[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static SupplyArea[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<SupplyArea> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<SupplyArea> createOne(array $attributes = [])
 * @phpstan-method static Proxy<SupplyArea> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<SupplyArea> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<SupplyArea> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<SupplyArea> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<SupplyArea> random(array $attributes = [])
 * @phpstan-method static Proxy<SupplyArea> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<SupplyArea> repository()
 * @phpstan-method static list<Proxy<SupplyArea>> all()
 * @phpstan-method static list<Proxy<SupplyArea>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<SupplyArea>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<SupplyArea>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<SupplyArea>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<SupplyArea>> randomSet(int $number, array $attributes = [])
 */
final class SupplyAreaFactory extends ModelFactory
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
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeThisMonth()),
            'name' => self::faker()->randomElement(['VG1', 'VG2', 'VG3', 'VG4', 'VG5', 'VG6']),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(SupplyArea $supplyArea): void {})
        ;
    }

    protected static function getClass(): string
    {
        return SupplyArea::class;
    }
}
