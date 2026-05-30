<?php
namespace src\Factory;

use src\Constant\Constant as C;

final class ReaderFactory
{
    private array $cache = [];

    private const MAP = [
        C::ABILITY               => ['reader' => 'AbilityReader',              'repo' => 'ability'],
        C::ARMOR                 => ['reader' => 'ArmorReader',                'repo' => 'armor'],
        C::CONDITION             => ['reader' => 'ConditionReader',            'repo' => 'condition'],
        C::DAMAGE_TYPE           => ['reader' => 'DamageTypeReader',           'repo' => 'damageType'],

        C::FEAT                  => ['reader' => 'FeatReader',                 'repo' => 'feat'],
        C::FEAT_ABILITY          => ['reader' => 'FeatAbilityReader',          'repo' => 'featAbility'],
        C::FEAT_TYPE             => ['reader' => 'FeatTypeReader',             'repo' => 'featType'],

        C::ITEM                  => ['reader' => 'ItemReader',                 'repo' => 'item'],
        C::LANGUAGE              => ['reader' => 'LanguageReader',             'repo' => 'language'],

        C::MONSTER               => ['reader' => 'MonsterReader',              'repo' => 'monster'],
        C::MONSTER_ABILITY       => ['reader' => 'MonsterAbilityReader',       'repo' => 'monsterAbility'],
        C::MONSTER_CONDITION     => ['reader' => 'MonsterConditionReader',     'repo' => 'monsterCondition'],
        C::MONSTER_LANGUAGE      => ['reader' => 'MonsterLanguageReader',      'repo' => 'monsterLanguage'],
        C::MONSTER_SUB_TYPE      => ['reader' => 'MonsterSubTypeReader',       'repo' => 'monsterSubType'],
        C::MONSTER_TYPE          => ['reader' => 'MonsterTypeReader',          'repo' => 'monsterType'],
        C::MONSTER_VISION_TYPE   => ['reader' => 'MonsterVisionTypeReader',    'repo' => 'monsterVisionType'],

        C::ORIGIN                => ['reader' => 'OriginReader',               'repo' => 'origin'],
        C::ORIGIN_ABILITY        => ['reader' => 'OriginAbilityReader',        'repo' => 'originAbility'],
        C::ORIGIN_ITEM           => ['reader' => 'OriginItemReader',           'repo' => 'originItem'],
        C::ORIGIN_SKILL          => ['reader' => 'OriginSkillReader',          'repo' => 'originSkill'],

        C::POWER                 => ['reader' => 'PowerReader',                'repo' => 'power'],
        C::REFERENCE             => ['reader' => 'ReferenceReader',            'repo' => 'reference'],

        C::SKILL                 => ['reader' => 'SkillReader',                'repo' => 'skill'],
        C::SPECIES               => ['reader' => 'SpecieReader',               'repo' => 'species'],
        C::SPECIE_POWER          => ['reader' => 'SpeciePowerReader',          'repo' => 'speciePower'],
        C::SPEED_TYPE            => ['reader' => 'SpeedTypeReader',            'repo' => 'speedType'],
        C::SPELL                 => ['reader' => 'SpellReader',                'repo' => 'spell'],
        C::SUB_SKILL             => ['reader' => 'SubSkillReader',             'repo' => 'subSkill'],

        C::TOOL                  => ['reader' => 'ToolReader',                 'repo' => 'tool'],
        C::VISION_TYPE           => ['reader' => 'VisionTypeReader',           'repo' => 'visionType'],
        C::WEAPON                => ['reader' => 'WeaponReader',               'repo' => 'weapon'],
        C::WEAPON_PROPERTY_VALUE => ['reader' => 'WeaponPropertyValueReader',  'repo' => 'weaponPropertyValue'],
    ];

    public function __construct(
        private RepositoryFactory $repositories
    ) {}

    public function __call(string $name, array $args): object
    {
        if (! isset($this->cache[$name])) {
            $this->cache[$name] = $this->make($name);
        }

        return $this->cache[$name];
    }

    private function make(string $name): object
    {
        $config = self::MAP[$name]
            ?? throw new \BadMethodCallException("Reader inconnu : '$name'.");

        $readerClass = 'src\\Service\\Reader\\' . $config['reader'];
        $repository  = $config['repo'];

        return new $readerClass(
            $this->repositories->$repository()
        );
    }
}
