<?php
namespace src\Factory;

use src\Service\Reader\{AbilityReader, ArmorReader, FeatReader, FeatTypeReader, ItemReader, OriginReader,
    PowerReader, ReferenceReader, SkillReader, SpecieReader, SpeedTypeReader, SpellReader, ToolReader,
    WeaponPropertyValueReader, WeaponReader};

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
        'power'               => PowerReader::class,
        'reference'           => ReferenceReader::class,
        'skill'               => SkillReader::class,
        'species'             => SpecieReader::class,
        'speedType'           => SpeedTypeReader::class,
        'spell'               => SpellReader::class,
        'tool'                => ToolReader::class,
        'weapon'              => WeaponReader::class,
        'weaponPropertyValue' => WeaponPropertyValueReader::class,
    ];

    public function __call(string $name, array $args): object
    {
        if (!isset($this->map[$name])) {
            throw new \BadMethodCallException("Reader inconnu : '$name'");
        }

        $readerClass = $this->map[$name];
        return new $readerClass($this->repositories->$name());
    }
}

