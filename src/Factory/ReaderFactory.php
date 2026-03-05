<?php
namespace src\Factory;

use src\Constant\Constant;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\ArmorReader;
use src\Service\Reader\ConditionReader;
use src\Service\Reader\DamageTypeReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\ItemReader;
use src\Service\Reader\LanguageReader;
use src\Service\Reader\MonsterAbilityReader;
use src\Service\Reader\MonsterConditionReader;
use src\Service\Reader\MonsterLanguageReader;
use src\Service\Reader\MonsterReader;
use src\Service\Reader\MonsterSubTypeReader;
use src\Service\Reader\MonsterTypeReader;
use src\Service\Reader\MonsterVisionTypeReader;
use src\Service\Reader\OriginAbilityReader;
use src\Service\Reader\OriginItemReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\OriginSkillReader;
use src\Service\Reader\PowerReader;
use src\Service\Reader\ReferenceReader;
use src\Service\Reader\SkillReader;
use src\Service\Reader\SpeciePowerReader;
use src\Service\Reader\SpecieReader;
use src\Service\Reader\SpeedTypeReader;
use src\Service\Reader\SpellReader;
use src\Service\Reader\SubSkillReader;
use src\Service\Reader\ToolReader;
use src\Service\Reader\VisionTypeReader;
use src\Service\Reader\WeaponPropertyValueReader;
use src\Service\Reader\WeaponReader;

final class ReaderFactory
{
    private array $builders = [];
    private array $cache    = [];

    public function __construct(
        private RepositoryFactory $repositories
    ) {}

    public function __call(string $name, array $args): object
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $builder                   = $this->builders[$name] ??= $this->resolveBuilder($name);
        return $this->cache[$name] = $builder();
    }

    private function resolveBuilder(string $name): callable
    {
        return match ($name) {
            // ----- Ability / Armor / Condition / DamageType -----
            'ability'              => fn()              => new AbilityReader($this->repositories->ability()),
            Constant::CST_ARMOR    => fn()    => new ArmorReader($this->repositories->armor()),
            'condition'            => fn()            => new ConditionReader($this->repositories->condition()),
            'damageType'           => fn()           => new DamageTypeReader($this->repositories->damageType()),

            // ----- Feat / FeatAbility / FeatType -----
            Constant::CST_FEAT     => fn()     => new FeatReader($this->repositories->feat()),
            'featAbility'          => fn()          => new FeatAbilityReader($this->repositories->featAbility()),
            Constant::CST_FEATTYPE => fn() => new FeatTypeReader($this->repositories->featType()),

            // ----- Item / Language -----
            'item'                 => fn()                 => new ItemReader($this->repositories->item()),
            'language'             => fn()             => new LanguageReader($this->repositories->language()),

            // ----- Monster & Co -----
            'monster'              => fn()              => new MonsterReader($this->repositories->monster()),
            'monsterAbility'       => fn()       => new MonsterAbilityReader($this->repositories->monsterAbility()),
            'monsterCondition'     => fn()     => new MonsterConditionReader($this->repositories->monsterCondition()),
            'monsterLanguage'      => fn()      => new MonsterLanguageReader($this->repositories->monsterLanguage()),
            'monsterSubType'       => fn()       => new MonsterSubTypeReader($this->repositories->monsterSubType()),
            'monsterType'          => fn()          => new MonsterTypeReader($this->repositories->monsterType()),
            'monsterVisionType'    => fn()    => new MonsterVisionTypeReader($this->repositories->monsterVisionType()),

            // ----- Origin & Co -----
            Constant::ORIGIN       => fn()       => new OriginReader($this->repositories->origin()),
            'originAbility'        => fn()        => new OriginAbilityReader($this->repositories->originAbility()),
            'originItem'           => fn()           => new OriginItemReader($this->repositories->originItem()),
            'originSkill'          => fn()          => new OriginSkillReader($this->repositories->originSkill()),

            // ----- Power / Reference / Skill -----
            'power'                => fn()                => new PowerReader($this->repositories->power()),
            'reference'            => fn()            => new ReferenceReader($this->repositories->reference()),
            'skill'                => fn()                => new SkillReader($this->repositories->skill()),

            // ----- Specie & Co -----
            'speciePower'          => fn()          => new SpeciePowerReader($this->repositories->speciePower()),
            Constant::SPECIES      => fn()      => new SpecieReader($this->repositories->specie()),
            'speedType'            => fn()            => new SpeedTypeReader($this->repositories->speedType()),

            // ----- Spell / SubSkill -----
            'spell'                => fn()                => new SpellReader($this->repositories->spell()),
            'subSkill'             => fn()             => new SubSkillReader($this->repositories->subSkill()),

            // ----- Tool / VisionType / Weapon / WeaponPropertyValue -----
            Constant::CST_TOOL     => fn()     => new ToolReader($this->repositories->tool()),
            'visionType'           => fn()           => new VisionTypeReader($this->repositories->visionType()),
            Constant::CST_WEAPON   => fn()   => new WeaponReader($this->repositories->weapon()),
            'weaponPropertyValue'  => fn()  => new WeaponPropertyValueReader($this->repositories->weaponPropertyValue()),

            default                => throw new \BadMethodCallException(
                "Reader inconnu: '$name'. Disponibles: " . implode(', ', $this->availableKeys())
            ),
        };
    }

}
