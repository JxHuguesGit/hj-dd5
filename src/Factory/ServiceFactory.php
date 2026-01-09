<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\Ability as RepositoryAbility;
use src\Repository\Armor as RepositoryArmor;
use src\Repository\Feat as RepositoryFeat;
use src\Repository\Origin as RepositoryOrigin;
use src\Repository\OriginAbility as RepositoryOriginAbility;
use src\Repository\OriginSkill as RepositoryOriginSkill;
use src\Repository\Species as RepositorySpecies;
use src\Repository\Skill as RepositorySkill;
use src\Repository\Tool as RepositoryTool;
use src\Repository\Weapon as RepositoryWeapon;
use src\Service\OriginService;
use src\Service\AbilityService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\ArmorReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\SkillReader;
use src\Service\Reader\SpecieReader;
use src\Service\Reader\ToolReader;
use src\Service\Reader\WeaponReader;

final class ServiceFactory
{
    public function __construct(
        private QueryBuilder $queryBuilder,
        private QueryExecutor $queryExecutor
    ) {
        $this->queryBuilder = $queryBuilder;
        $this->queryExecutor = $queryExecutor;
    }

    public function getFeatReader(): FeatReader
    {
        $featRepo = new RepositoryFeat($this->queryBuilder, $this->queryExecutor);
        return new FeatReader($featRepo);
    }

    public function getOriginReader(): OriginReader
    {
        $originRepo = new RepositoryOrigin($this->queryBuilder, $this->queryExecutor);
        return new OriginReader($originRepo);
    }

    public function getSpecieReader(): SpecieReader
    {
        $speciesRepo = new RepositorySpecies($this->queryBuilder, $this->queryExecutor);
        return new SpecieReader($speciesRepo);
    }
    
    public function getArmorReader(): ArmorReader
    {
        $repositoryFactory = new RepositoryFactory(
            $this->queryBuilder,
            $this->queryExecutor
        );

        $readerFactory = new ReaderFactory($repositoryFactory);

        return $readerFactory->armor();
    }

    public function getToolReader(): ToolReader
    {
        $repo = new RepositoryTool($this->queryBuilder, $this->queryExecutor);
        return new ToolReader($repo);
    }
    
    public function getWeaponReader(): WeaponReader
    {
        $repo = new RepositoryWeapon($this->queryBuilder, $this->queryExecutor);
        return new WeaponReader($repo);
    }

    public function getSkillReader(): SkillReader
    {
        $repo = new RepositorySkill($this->queryBuilder, $this->queryExecutor);
        return new SkillReader($repo);
    }


    public function getRpgAbilityService(): AbilityReader
    {
        $repo = new RepositoryAbility($this->queryBuilder, $this->queryExecutor);
        return new AbilityReader($repo);
    }

    public function origin(): OriginService
    {
        $featRepo     = new RepositoryFeat($this->queryBuilder, $this->queryExecutor);
        $toolRepo     = new RepositoryTool($this->queryBuilder, $this->queryExecutor);
        $originSkillRepo    = new RepositoryOriginSkill($this->queryBuilder, $this->queryExecutor);
        $originAbilityRepo  = new RepositoryOriginAbility($this->queryBuilder, $this->queryExecutor);

        $skillRepo    = new RepositorySkill($this->queryBuilder, $this->queryExecutor);
        $skillQueryService   = new SkillReader($skillRepo);
        $abilityRepo  = new RepositoryAbility($this->queryBuilder, $this->queryExecutor);
        $abilityQueryService = new AbilityReader($abilityRepo);
        
        return new OriginService($featRepo, $toolRepo, $originSkillRepo, $originAbilityRepo, $skillQueryService, $abilityQueryService);
    }
}
