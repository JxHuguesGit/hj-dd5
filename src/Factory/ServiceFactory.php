<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\{AbilityRepository, FeatRepository, ItemRepository, PowerRepository, OriginRepository};
use src\Repository\OriginAbilityRepository;
use src\Repository\OriginItemRepository;
use src\Repository\OriginSkillRepository;
use src\Repository\SpeciePowerRepository;
use src\Repository\{SubSkillRepository, SkillRepository, ToolRepository};
use src\Service\Domain\{OriginService, SpecieService, SkillService, WpPostService};
use src\Service\Formatter\WeaponPropertiesFormatter;
use src\Service\Reader\{AbilityReader, ItemReader, OriginReader, PowerReader, SkillReader};

final class ServiceFactory
{
    public function __construct(
        private QueryBuilder $queryBuilder,
        private QueryExecutor $queryExecutor
    ) {
        $this->queryBuilder = $queryBuilder;
        $this->queryExecutor = $queryExecutor;
    }

    public function wordPress(): WpPostService
    {
        return new WpPostService();
    }

    public function weaponProperties(): WeaponPropertiesFormatter
    {
        return new WeaponPropertiesFormatter();
    }

    public function origin(): OriginService
    {
        $featRepo     = new FeatRepository($this->queryBuilder, $this->queryExecutor);
        $toolRepo     = new ToolRepository($this->queryBuilder, $this->queryExecutor);
        $originSkillRepo    = new OriginSkillRepository($this->queryBuilder, $this->queryExecutor);
        $originAbilityRepo  = new OriginAbilityRepository($this->queryBuilder, $this->queryExecutor);
        $originItemRepo     = new OriginItemRepository($this->queryBuilder, $this->queryExecutor);

        $skillRepo    = new SkillRepository($this->queryBuilder, $this->queryExecutor);
        $skillQueryService   = new SkillReader($skillRepo);
        $abilityRepo  = new AbilityRepository($this->queryBuilder, $this->queryExecutor);
        $abilityQueryService = new AbilityReader($abilityRepo);
        $itemRepo  = new ItemRepository($this->queryBuilder, $this->queryExecutor);
        $itemQueryService = new ItemReader($itemRepo);

        return new OriginService(
            $featRepo,
            $toolRepo,
            $originSkillRepo,
            $originAbilityRepo,
            $originItemRepo,
            $skillQueryService,
            $abilityQueryService,
            $itemQueryService
        );
    }

    public function skill(): SkillService
    {
        $originSkillRepository  = new OriginSkillRepository($this->queryBuilder, $this->queryExecutor);
        $subSkillRepo  = new SubSkillRepository($this->queryBuilder, $this->queryExecutor);
        $originRepo  = new OriginRepository($this->queryBuilder, $this->queryExecutor);
        $originReader = new OriginReader($originRepo);

        return new SkillService($originSkillRepository, $subSkillRepo, $originReader);
    }

    public function specie(): SpecieService
    {
        $speciePowerRepo  = new SpeciePowerRepository($this->queryBuilder, $this->queryExecutor);
        $powerRepo  = new PowerRepository($this->queryBuilder, $this->queryExecutor);
        $powerReader = new PowerReader($powerRepo);

        return new SpecieService($speciePowerRepo, $powerReader);
    }
}
