<?php

namespace App\Factory;

use App\Entity\Import;
use App\Enum\ImportStatus;
use App\Enum\ImportType;
use App\Repository\ImportRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Import>
 *
 * @method        Import|Proxy                     create(array|callable $attributes = [])
 * @method static Import|Proxy                     createOne(array $attributes = [])
 * @method static Import|Proxy                     find(object|array|mixed $criteria)
 * @method static Import|Proxy                     findOrCreate(array $attributes)
 * @method static Import|Proxy                     first(string $sortedField = 'id')
 * @method static Import|Proxy                     last(string $sortedField = 'id')
 * @method static Import|Proxy                     random(array $attributes = [])
 * @method static Import|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ImportRepository|RepositoryProxy repository()
 * @method static Import[]|Proxy[]                 all()
 * @method static Import[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Import[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Import[]|Proxy[]                 findBy(array $attributes)
 * @method static Import[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Import[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Import> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Import> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Import> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Import> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Import> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Import> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Import> random(array $attributes = [])
 * @phpstan-method static Proxy<Import> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Import> repository()
 * @phpstan-method static list<Proxy<Import>> all()
 * @phpstan-method static list<Proxy<Import>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Import>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Import>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Import>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Import>> randomSet(int $number, array $attributes = [])
 */
final class ImportFactory extends ModelFactory
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
            'caption' => self::faker()->text(255),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeThisYear()),
            'createdBy' => UserFactory::randomOrCreate(),
            'fileExtension' => self::faker()->randomElement(['csv']),
            'filePath' => self::faker()->text(255),
            'fileSize' => self::faker()->randomNumber(),
            'fileType' => self::faker()->randomElement(['text/plain', 'text/csv']),
            'hospital' => HospitalFactory::randomOrCreate(),
            'rowCount' => self::faker()->randomNumber(),
            'runCount' => self::faker()->randomNumber(),
            'runTime' => self::faker()->randomNumber(),
            'skippedRows' => self::faker()->randomNumber(),
            'status' => self::faker()->randomElement(ImportStatus::cases()),
            'type' => self::faker()->randomElement(ImportType::cases()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Import $import): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Import::class;
    }
}
