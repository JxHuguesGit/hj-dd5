<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\Repository;
use src\Repository\ArmorRepository;
use src\Repository\FeatRepository;
use src\Repository\OriginRepository;
use src\Repository\SkillRepository;
use src\Repository\SpeciesRepository;
use src\Repository\ToolRepository;
use src\Repository\WeaponRepository;

class RepositoryFactory
{
    public function __construct(
        private QueryBuilder $builder,
        private QueryExecutor $executor
    ) {}
    
    public function armor(): ArmorRepository
    {
        return new ArmorRepository($this->builder, $this->executor);
    }
    
    public function feat(): FeatRepository
    {
        return new FeatRepository($this->builder, $this->executor);
    }

    public function origin(): OriginRepository
    {
        return new OriginRepository($this->builder, $this->executor);
    }
    
    public function skill(): SkillRepository
    {
        return new SkillRepository($this->builder, $this->executor);
    }
    
    public function species(): SpeciesRepository
    {
        return new SpeciesRepository($this->builder, $this->executor);
    }
    
    public function tool(): ToolRepository
    {
        return new ToolRepository($this->builder, $this->executor);
    }

    public function weapon(): WeaponRepository
    {
        return new WeaponRepository($this->builder, $this->executor);
    }


    public static function create(string $repositoryClass): Repository
    {
        return new $repositoryClass(
            new QueryBuilder(),
            new QueryExecutor()
        );
    }
}
