<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\Repository;
use src\Repository\Armor as RepositoryArmor;
use src\Repository\Feat as RepositoryFeat;
use src\Repository\Origin as RepositoryOrigin;
use src\Repository\Skill as RepositorySkill;
use src\Repository\Species as RepositorySpecies;
use src\Repository\Tool as RepositoryTool;
use src\Repository\Weapon as RepositoryWeapon;

class RepositoryFactory
{
    public function __construct(
        private QueryBuilder $builder,
        private QueryExecutor $executor
    ) {}
    
    public function armor(): RepositoryArmor
    {
        return new RepositoryArmor($this->builder, $this->executor);
    }
    
    public function feat(): RepositoryFeat
    {
        return new RepositoryFeat($this->builder, $this->executor);
    }

    public function origin(): RepositoryOrigin
    {
        return new RepositoryOrigin($this->builder, $this->executor);
    }
    
    public function skill(): RepositorySkill
    {
        return new RepositorySkill($this->builder, $this->executor);
    }
    
    public function species(): RepositorySpecies
    {
        return new RepositorySpecies($this->builder, $this->executor);
    }
    
    public function tool(): RepositoryTool
    {
        return new RepositoryTool($this->builder, $this->executor);
    }

    public function weapon(): RepositoryWeapon
    {
        return new RepositoryWeapon($this->builder, $this->executor);
    }


    public static function create(string $repositoryClass): Repository
    {
        return new $repositoryClass(
            new QueryBuilder(),
            new QueryExecutor()
        );
    }
}
