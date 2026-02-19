<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\{AbilityRepository, ArmorRepository, FeatRepository, OriginAbilityRepository, OriginItemRepository,
    OriginSkillRepository, FeatTypeRepository, ItemRepository, OriginRepository, PowerRepository, ReferenceRepository,
    SkillRepository, SpeciePowerRepository, SpeedTypeRepository, SubSkillRepository, SpeciesRepository, SpellRepository,
    ToolRepository, WeaponPropertyValueRepository, WeaponRepository};

class RepositoryFactory
{
    private array $map = [
        'ability'             => AbilityRepository::class,
        'armor'               => ArmorRepository::class,
        'feat'                => FeatRepository::class,
        'featType'            => FeatTypeRepository::class,
        'item'                => ItemRepository::class,
        'origin'              => OriginRepository::class,
        'originAbility'       => OriginAbilityRepository::class,
        'originItem'          => OriginItemRepository::class,
        'originSkill'         => OriginSkillRepository::class,
        'power'               => PowerRepository::class,
        'reference'           => ReferenceRepository::class,
        'skill'               => SkillRepository::class,
        'speedType'           => SpeedTypeRepository::class,
        'spell'               => SpellRepository::class,
        'subSkill'            => SubSkillRepository::class,
        'speciePower'         => SpeciePowerRepository::class,
        'species'             => SpeciesRepository::class,
        'tool'                => ToolRepository::class,
        'weapon'              => WeaponRepository::class,
        'weaponPropertyValue' => WeaponPropertyValueRepository::class,
    ];

    public function __construct(
        private QueryBuilder $builder,
        private QueryExecutor $executor
    ) {}

    public function __call(string $name, array $args): object
    {
        if (!isset($this->map[$name])) {
            throw new \BadMethodCallException("Repository inconnu : '$name'");
        }

        $class = $this->map[$name];
        return new $class($this->builder, $this->executor);
    }
}
