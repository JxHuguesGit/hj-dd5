<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgAbility;
use src\Repository\RpgArmor;
use src\Repository\RpgFeat;
use src\Repository\RpgOrigin;
use src\Repository\RpgOriginAbility;
use src\Repository\RpgOriginSkill;
use src\Repository\RpgSkill;
use src\Repository\RpgTool;
use src\Service\RpgAbilityService;
use src\Service\RpgAbilityQueryService;
use src\Service\RpgArmorService;
use src\Service\RpgOriginQueryService;
use src\Service\RpgOriginService;
use src\Service\RpgSkillQueryService;

final class ServiceFactory
{
    public function __construct(
        private QueryBuilder $queryBuilder,
        private QueryExecutor $queryExecutor
    ) {
        $this->queryBuilder = $queryBuilder;
        $this->queryExecutor = $queryExecutor;
    }

    public function getRpgOriginQueryService(): RpgOriginQueryService
    {
        $originRepo = new RpgOrigin($this->queryBuilder, $this->queryExecutor);
        return new RpgOriginQueryService($originRepo);
    }
    
    public function getRpgAbilityService(): RpgAbilityService
    {
        $repo = new RpgAbility($this->queryBuilder, $this->queryExecutor);
        return new RpgAbilityService($repo);
    }
    
    public function getRpgArmorService(): RpgArmorService
    {
        $repo = new RpgArmor($this->queryBuilder, $this->queryExecutor);
        return new RpgArmorService($repo);
    }
    
    public function getRpgFeatService(): RpgFeatService
    {
        $repo = new RpgFeat($this->queryBuilder, $this->queryExecutor);
        return new RpgFeatService($repo);
    }

    public function getRpgOriginService(): RpgOriginService
    {
        $featRepo     = new RpgFeat($this->queryBuilder, $this->queryExecutor);
        $toolRepo     = new RpgTool($this->queryBuilder, $this->queryExecutor);
        $originSkillRepo    = new RpgOriginSkill($this->queryBuilder, $this->queryExecutor);
        $originAbilityRepo  = new RpgOriginAbility($this->queryBuilder, $this->queryExecutor);
        
        $skillRepo    = new RpgSkill($this->queryBuilder, $this->queryExecutor);
        $skillQueryService   = new RpgSkillQueryService($skillRepo);
        $abilityRepo  = new RpgAbility($this->queryBuilder, $this->queryExecutor);
        $abilityQueryService = new RpgAbilityQueryService($abilityRepo);
        
        return new RpgOriginService($featRepo, $toolRepo, $originSkillRepo, $originAbilityRepo, $skillQueryService, $abilityQueryService);
    }
}
