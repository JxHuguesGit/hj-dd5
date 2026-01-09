<?php
namespace src\Factory;

use src\Service\Reader\ArmorReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\SkillReader;
use src\Service\Reader\SpecieReader;
use src\Service\Reader\ToolReader;
use src\Service\Reader\WeaponReader;

final class ReaderFactory
{
    public function __construct(
        private RepositoryFactory $repositories
    ) {}

    public function armor(): ArmorReader
    {
        return new ArmorReader($this->repositories->armor());
    }

    public function feat(): FeatReader
    {
        return new FeatReader($this->repositories->feat());
    }

    public function origin(): OriginReader
    {
        return new OriginReader($this->repositories->origin());
    }

    public function skill(): SkillReader
    {
        return new SkillReader($this->repositories->skill());
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

}
