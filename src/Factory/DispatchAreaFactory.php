<?php

namespace App\Factory;

use App\Entity\DispatchArea;
use App\Faker\Provider\Areas;
use App\Repository\DispatchAreaRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<DispatchArea>
 *
 * @method        DispatchArea|Proxy                     create(array|callable $attributes = [])
 * @method static DispatchArea|Proxy                     createOne(array $attributes = [])
 * @method static DispatchArea|Proxy                     find(object|array|mixed $criteria)
 * @method static DispatchArea|Proxy                     findOrCreate(array $attributes)
 * @method static DispatchArea|Proxy                     first(string $sortedField = 'id')
 * @method static DispatchArea|Proxy                     last(string $sortedField = 'id')
 * @method static DispatchArea|Proxy                     random(array $attributes = [])
 * @method static DispatchArea|Proxy                     randomOrCreate(array $attributes = [])
 * @method static DispatchAreaRepository|RepositoryProxy repository()
 * @method static DispatchArea[]|Proxy[]                 all()
 * @method static DispatchArea[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static DispatchArea[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static DispatchArea[]|Proxy[]                 findBy(array $attributes)
 * @method static DispatchArea[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static DispatchArea[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<DispatchArea> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<DispatchArea> createOne(array $attributes = [])
 * @phpstan-method static Proxy<DispatchArea> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<DispatchArea> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<DispatchArea> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<DispatchArea> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<DispatchArea> random(array $attributes = [])
 * @phpstan-method static Proxy<DispatchArea> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<DispatchArea> repository()
 * @phpstan-method static list<Proxy<DispatchArea>> all()
 * @phpstan-method static list<Proxy<DispatchArea>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<DispatchArea>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<DispatchArea>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<DispatchArea>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<DispatchArea>> randomSet(int $number, array $attributes = [])
 */
final class DispatchAreaFactory extends ModelFactory
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
            'name' => Areas::district(),
            'state' => StateFactory::random(),
            'supplyArea' => self::faker()->boolean(10) ? SupplyAreaFactory::random() : null,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(DispatchArea $dispatchArea): void {})
        ;
    }

    protected static function getClass(): string
    {
        return DispatchArea::class;
    }
}
