<?php
namespace src\Factory;

use src\Service\Reader\AbilityReader;
use src\Service\Reader\ArmorReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\ItemReader;
use src\Service\Reader\OriginAbilityReader;
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
use src\Service\Reader\WeaponPropertyValueReader;
use src\Service\Reader\WeaponReader;

final class ReaderFactory
{
    public function __construct(
        private RepositoryFactory $repositories
    ) {}

    private array $map = [
        'ability'             => AbilityReader::class,
        'armor'               => ArmorReader::class,
        'feat'                => FeatReader::class,
        'featType'            => FeatTypeReader::class,
        'item'                => ItemReader::class,
        'origin'              => OriginReader::class,
        'originAbility'       => OriginAbilityReader::class,
        'originSkill'         => OriginSkillReader::class,
        'power'               => PowerReader::class,
        'reference'           => ReferenceReader::class,
        'skill'               => SkillReader::class,
        'speciePower'         => SpeciePowerReader::class,
        'species'             => SpecieReader::class,
        'speedType'           => SpeedTypeReader::class,
        'spell'               => SpellReader::class,
        'subSkill'            => SubSkillReader::class,
        'tool'                => ToolReader::class,
        'weapon'              => WeaponReader::class,
        'weaponPropertyValue' => WeaponPropertyValueReader::class,
    ];

    public function __call(string $name, array $args): object
    {
        if (! isset($this->map[$name])) {
            throw new \BadMethodCallException("Reader inconnu : '$name'");
        }

        $readerClass = $this->map[$name];
        return new $readerClass($this->repositories->$name());
    }
}
