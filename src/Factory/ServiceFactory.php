<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgAbility;
use src\Repository\Armor as RepositoryArmor;
use src\Repository\RpgFeat;
use src\Repository\RpgOrigin;
use src\Repository\RpgOriginAbility;
use src\Repository\RpgOriginSkill;
use src\Repository\Species as RepositorySpecies;
use src\Repository\Skill as RepositorySkill;
use src\Repository\Tool as RepositoryTool;
use src\Repository\Weapon as RepositoryWeapon;
use src\Service\RpgAbilityService;
use src\Service\RpgAbilityQueryService;
use src\Service\Armor\ArmorReader;
use src\Service\RpgFeatService;
use src\Service\RpgFeatQueryService;
use src\Service\RpgOriginQueryService;
use src\Service\RpgOriginService;
use src\Service\Skill\SkillReader;
use src\Service\Species\SpecieReader;
use src\Service\Tool\ToolReader;
use src\Service\Weapon\WeaponReader;

final class ServiceFactory
{
    public function __construct(
        private QueryBuilder $queryBuilder,
        private QueryExecutor $queryExecutor
    ) {
        $this->queryBuilder = $queryBuilder;
        $this->queryExecutor = $queryExecutor;
    }

    public function getRpgFeatQueryService(): RpgFeatQueryService
    {
        $featRepo = new RpgFeat($this->queryBuilder, $this->queryExecutor);
        return new RpgFeatQueryService($featRepo);
    }

    public function getRpgOriginQueryService(): RpgOriginQueryService
    {
        $originRepo = new RpgOrigin($this->queryBuilder, $this->queryExecutor);
        return new RpgOriginQueryService($originRepo);
    }

    public function getSpecieReader(): SpecieReader
    {
        $speciesRepo = new RepositorySpecies($this->queryBuilder, $this->queryExecutor);
        return new SpecieReader($speciesRepo);
    }
    
    public function getArmorReader(): ArmorReader
    {
        $repo = new RepositoryArmor($this->queryBuilder, $this->queryExecutor);
        return new ArmorReader($repo);
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


    public function getRpgAbilityService(): RpgAbilityService
    {
        $repo = new RpgAbility($this->queryBuilder, $this->queryExecutor);
        return new RpgAbilityService($repo);
    }
    
    public function getRpgFeatService(): RpgFeatService
    {
        $repo = new RpgFeat($this->queryBuilder, $this->queryExecutor);
        return new RpgFeatService($repo);
    }

    public function getRpgOriginService(): RpgOriginService
    {
        $featRepo     = new RpgFeat($this->queryBuilder, $this->queryExecutor);
        $toolRepo     = new RepositoryTool($this->queryBuilder, $this->queryExecutor);
        $originSkillRepo    = new RpgOriginSkill($this->queryBuilder, $this->queryExecutor);
        $originAbilityRepo  = new RpgOriginAbility($this->queryBuilder, $this->queryExecutor);

        $skillRepo    = new RepositorySkill($this->queryBuilder, $this->queryExecutor);
        $skillQueryService   = new SkillReader($skillRepo);
        $abilityRepo  = new RpgAbility($this->queryBuilder, $this->queryExecutor);
        $abilityQueryService = new RpgAbilityQueryService($abilityRepo);
        
        return new RpgOriginService($featRepo, $toolRepo, $originSkillRepo, $originAbilityRepo, $skillQueryService, $abilityQueryService);
    }
}
