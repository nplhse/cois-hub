<?php

namespace App\Factory;

use App\Entity\Hospital;
use App\Enum\HospitalLocation;
use App\Enum\HospitalSize;
use App\Enum\HospitalTier;
use App\Faker\Provider\Area;
use App\Repository\HospitalRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Hospital>
 *
 * @method        Hospital|Proxy                     create(array|callable $attributes = [])
 * @method static Hospital|Proxy                     createOne(array $attributes = [])
 * @method static Hospital|Proxy                     find(object|array|mixed $criteria)
 * @method static Hospital|Proxy                     findOrCreate(array $attributes)
 * @method static Hospital|Proxy                     first(string $sortedField = 'id')
 * @method static Hospital|Proxy                     last(string $sortedField = 'id')
 * @method static Hospital|Proxy                     random(array $attributes = [])
 * @method static Hospital|Proxy                     randomOrCreate(array $attributes = [])
 * @method static HospitalRepository|RepositoryProxy repository()
 * @method static Hospital[]|Proxy[]                 all()
 * @method static Hospital[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Hospital[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Hospital[]|Proxy[]                 findBy(array $attributes)
 * @method static Hospital[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Hospital[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Hospital> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Hospital> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Hospital> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Hospital> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Hospital> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Hospital> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Hospital> random(array $attributes = [])
 * @phpstan-method static Proxy<Hospital> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Hospital> repository()
 * @phpstan-method static list<Proxy<Hospital>> all()
 * @phpstan-method static list<Proxy<Hospital>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Hospital>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Hospital>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Hospital>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Hospital>> randomSet(int $number, array $attributes = [])
 */
final class HospitalFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();

        self::faker()->addProvider(new \App\Faker\Provider\Hospital(self::faker()));
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'address' => AddressFactory::new(),
            'beds' => self::faker()->numberBetween(100, 1250),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeThisYear()),
            'createdBy' => UserFactory::random(),
            'dispatchArea' => DispatchAreaFactory::random(),
            'location' => self::faker()->randomElement(HospitalLocation::cases()),
            'name' => self::faker()->hospital(),
            'owner' => UserFactory::random(),
            'size' => self::faker()->randomElement(HospitalSize::cases()),
            'state' => StateFactory::random(),
            'tier' => self::faker()->randomElement(HospitalTier::cases()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Hospital $hospital): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Hospital::class;
    }
}
