<?php
namespace src\Factory;

use src\Service\Reader\{AbilityReader, ArmorReader, FeatReader, FeatTypeReader, ItemReader, OriginReader, PowerReader, SkillReader, SpecieReader, SpellReader, ToolReader, WeaponPropertyValueReader, WeaponReader};

final class ReaderFactory
{
    public function __construct(
        private RepositoryFactory $repositories
    ) {}

    public function ability(): AbilityReader
    {
        return new AbilityReader($this->repositories->ability());
    }

    public function armor(): ArmorReader
    {
        return new ArmorReader($this->repositories->armor());
    }

    public function feat(): FeatReader
    {
        return new FeatReader($this->repositories->feat());
    }

    public function featType(): FeatTypeReader
    {
        return new FeatTypeReader($this->repositories->featType());
    }

    public function item(): ItemReader
    {
        return new ItemReader($this->repositories->item());
    }

    public function origin(): OriginReader
    {
        return new OriginReader($this->repositories->origin());
    }

    public function power(): PowerReader
    {
        return new PowerReader($this->repositories->power());
    }

    public function skill(): SkillReader
    {
        return new SkillReader($this->repositories->skill());
    }

    public function spell(): SpellReader
    {
        return new SpellReader($this->repositories->spell());
    }

    public function species(): SpecieReader
    {
        return new SpecieReader($this->repositories->species());
    }

    public function tool(): ToolReader
    {
        return new ToolReader($this->repositories->tool());
    }

    public function weapon(): WeaponReader
    {
        return new WeaponReader($this->repositories->weapon());
    }

    public function weaponPropertyValue(): WeaponPropertyValueReader
    {
        return new WeaponPropertyValueReader($this->repositories->weaponPropertyValue());
    }

}
