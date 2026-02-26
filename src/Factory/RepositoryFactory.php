<?php
namespace src\Factory;

use src\Constant\Constant;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\AbilityRepository;
use src\Repository\ArmorRepository;
use src\Repository\ConditionRepository;
use src\Repository\DamageTypeRepository;
use src\Repository\FeatRepository;
use src\Repository\FeatTypeRepository;
use src\Repository\ItemRepository;
use src\Repository\MonsterConditionRepository;
use src\Repository\MonsterRepository;
use src\Repository\MonsterSubTypeRepository;
use src\Repository\MonsterTypeRepository;
use src\Repository\OriginAbilityRepository;
use src\Repository\OriginItemRepository;
use src\Repository\OriginRepository;
use src\Repository\OriginSkillRepository;
use src\Repository\PowerRepository;
use src\Repository\ReferenceRepository;
use src\Repository\SkillRepository;
use src\Repository\SpeciePowerRepository;
use src\Repository\SpeciesRepository;
use src\Repository\SpeedTypeRepository;
use src\Repository\SpellRepository;
use src\Repository\SubSkillRepository;
use src\Repository\ToolRepository;
use src\Repository\WeaponPropertyValueRepository;
use src\Repository\WeaponRepository;

class RepositoryFactory
{
    private array $map = [
        'ability'              => AbilityRepository::class,
        Constant::CST_ARMOR    => ArmorRepository::class,
        'condition'            => ConditionRepository::class,
        'damageType'           => DamageTypeRepository::class,
        Constant::CST_FEAT     => FeatRepository::class,
        Constant::CST_FEATTYPE => FeatTypeRepository::class,
        'item'                 => ItemRepository::class,
        'monster'              => MonsterRepository::class,
        'monsterCondition'     => MonsterConditionRepository::class,
        'monsterSubType'       => MonsterSubTypeRepository::class,
        'monsterType'          => MonsterTypeRepository::class,
        Constant::ORIGIN       => OriginRepository::class,
        'originAbility'        => OriginAbilityRepository::class,
        'originItem'           => OriginItemRepository::class,
        'originSkill'          => OriginSkillRepository::class,
        'power'                => PowerRepository::class,
        'reference'            => ReferenceRepository::class,
        'skill'                => SkillRepository::class,
        'speciePower'          => SpeciePowerRepository::class,
        Constant::SPECIES      => SpeciesRepository::class,
        'speedType'            => SpeedTypeRepository::class,
        'spell'                => SpellRepository::class,
        'subSkill'             => SubSkillRepository::class,
        Constant::CST_TOOL     => ToolRepository::class,
        Constant::CST_WEAPON   => WeaponRepository::class,
        'weaponPropertyValue'  => WeaponPropertyValueRepository::class,
    ];

    public function __construct(
        private QueryBuilder $builder,
        private QueryExecutor $executor
    ) {}

    public function __call(string $name, array $args): object
    {
        if (! isset($this->map[$name])) {
            throw new \BadMethodCallException("Repository inconnu : '$name'");
        }

        $class = $this->map[$name];
        return new $class($this->builder, $this->executor);
    }
}
