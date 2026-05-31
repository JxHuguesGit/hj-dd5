<?php
namespace src\Factory;

use src\Constant\Constant as C;

final class ReaderFactory
{
    private array $cache = [];

    private const MAP = [
        C::ABILITY               => [C::READER => 'AbilityReader',              C::REPO => C::ABILITY],
        C::ARMOR                 => [C::READER => 'ArmorReader',                C::REPO => C::ARMOR],
        C::CONDITION             => [C::READER => 'ConditionReader',            C::REPO => C::CONDITION],
        C::DAMAGE_TYPE           => [C::READER => 'DamageTypeReader',           C::REPO => C::DAMAGE_TYPE],

        C::FEAT                  => [C::READER => 'FeatReader',                 C::REPO => C::FEAT],
        C::FEAT_ABILITY          => [C::READER => 'FeatAbilityReader',          C::REPO => C::FEAT_ABILITY],
        C::FEAT_TYPE             => [C::READER => 'FeatTypeReader',             C::REPO => C::FEAT_TYPE],

        C::ITEM                  => [C::READER => 'ItemReader',                 C::REPO => C::ITEM],
        C::LANGUAGE              => [C::READER => 'LanguageReader',             C::REPO => C::LANGUAGE],

        C::MONSTER               => [C::READER => 'MonsterReader',              C::REPO => C::MONSTER],
        C::MONSTER_ABILITY       => [C::READER => 'MonsterAbilityReader',       C::REPO => C::MONSTER_ABILITY],
        C::MONSTER_CONDITION     => [C::READER => 'MonsterConditionReader',     C::REPO => C::MONSTER_CONDITION],
        C::MONSTER_LANGUAGE      => [C::READER => 'MonsterLanguageReader',      C::REPO => C::MONSTER_LANGUAGE],
        C::MONSTER_SUB_TYPE      => [C::READER => 'MonsterSubTypeReader',       C::REPO => C::MONSTER_SUB_TYPE],
        C::MONSTER_TYPE          => [C::READER => 'MonsterTypeReader',          C::REPO => C::MONSTER_TYPE],
        C::MONSTER_VISION_TYPE   => [C::READER => 'MonsterVisionTypeReader',    C::REPO => C::MONSTER_VISION_TYPE],

        C::ORIGIN                => [C::READER => 'OriginReader',               C::REPO => C::ORIGIN],
        C::ORIGIN_ABILITY        => [C::READER => 'OriginAbilityReader',        C::REPO => C::ORIGIN_ABILITY],
        C::ORIGIN_ITEM           => [C::READER => 'OriginItemReader',           C::REPO => C::ORIGIN_ITEM],
        C::ORIGIN_SKILL          => [C::READER => 'OriginSkillReader',          C::REPO => C::ORIGIN_SKILL],

        C::POWER                 => [C::READER => 'PowerReader',                C::REPO => C::POWER],
        C::REFERENCE             => [C::READER => 'ReferenceReader',            C::REPO => C::REFERENCE],

        C::SKILL                 => [C::READER => 'SkillReader',                C::REPO => C::SKILL],
        C::SPECIES               => [C::READER => 'SpecieReader',               C::REPO => C::SPECIES],
        C::SPECIE_POWER          => [C::READER => 'SpeciePowerReader',          C::REPO => C::SPECIE_POWER],
        C::SPEED_TYPE            => [C::READER => 'SpeedTypeReader',            C::REPO => C::SPEED_TYPE],
        C::SPELL                 => [C::READER => 'SpellReader',                C::REPO => C::SPELL],
        C::SUB_SKILL             => [C::READER => 'SubSkillReader',             C::REPO => C::SUB_SKILL],

        C::TOOL                  => [C::READER => 'ToolReader',                 C::REPO => C::TOOL],
        C::VISION_TYPE           => [C::READER => 'VisionTypeReader',           C::REPO => C::VISION_TYPE],
        C::WEAPON                => [C::READER => 'WeaponReader',               C::REPO => C::WEAPON],
        C::WEAPON_PROPERTY_VALUE => [C::READER => 'WeaponPropertyValueReader',  C::REPO => C::WEAPON_PROPERTY_VALUE],
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

        $readerClass = 'src\\Service\\Reader\\' . $config[C::READER];
        $repository  = $config[C::REPO];

        return new $readerClass(
            $this->repositories->$repository()
        );
    }
}
