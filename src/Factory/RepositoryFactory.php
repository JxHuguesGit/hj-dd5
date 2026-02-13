<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\{AbilityRepository, AbilityRepositoryInterface, ArmorRepository, ArmorRepositoryInterface, FeatRepository, FeatRepositoryInterface};
use src\Repository\{FeatTypeRepository, FeatTypeRepositoryInterface, ItemRepository, ItemRepositoryInterface, OriginRepository, OriginRepositoryInterface};
use src\Repository\{PowerRepository, PowerRepositoryInterface, SkillRepository, SkillRepositoryInterface, SubSkillRepository, SubSkillRepositoryInterface};
use src\Repository\{SpeciesRepository, SpeciesRepositoryInterface, SpellRepository, SpellRepositoryInterface, ToolRepository, ToolRepositoryInterface};
use src\Repository\{WeaponPropertyValueRepository, WeaponPropertyValueRepositoryInterface, WeaponRepository, WeaponRepositoryInterface};

class RepositoryFactory
{
    public function __construct(
        private QueryBuilder $builder,
        private QueryExecutor $executor
    ) {}
    
    private function make(string $repositoryClass): object
    {
        return new $repositoryClass($this->builder, $this->executor);
    }

    public function ability(): AbilityRepositoryInterface
    {
        return $this->make(AbilityRepository::class);
    }
    
    public function armor(): ArmorRepositoryInterface
    {
        return $this->make(ArmorRepository::class);
    }
    
    public function feat(): FeatRepositoryInterface
    {
        return $this->make(FeatRepository::class);
    }
    
    public function featType(): FeatTypeRepositoryInterface
    {
        return $this->make(FeatTypeRepository::class);
    }
    
    public function item(): ItemRepositoryInterface
    {
        return $this->make(ItemRepository::class);
    }

    public function origin(): OriginRepositoryInterface
    {
        return $this->make(OriginRepository::class);
    }

    public function power(): PowerRepositoryInterface
    {
        return $this->make(PowerRepository::class);
    }
    
    public function skill(): SkillRepositoryInterface
    {
        return $this->make(SkillRepository::class);
    }
    
    public function spell(): SpellRepositoryInterface
    {
        return $this->make(SpellRepository::class);
    }
    
    public function subSkill(): SubSkillRepositoryInterface
    {
        return $this->make(SubSkillRepository::class);
    }
    
    public function species(): SpeciesRepositoryInterface
    {
        return $this->make(SpeciesRepository::class);
    }
    
    public function tool(): ToolRepositoryInterface
    {
        return $this->make(ToolRepository::class);
    }

    public function weapon(): WeaponRepositoryInterface
    {
        return $this->make(WeaponRepository::class);
    }

    public function weaponPropertyValue(): WeaponPropertyValueRepositoryInterface
    {
        return $this->make(WeaponPropertyValueRepository::class);
    }
}
