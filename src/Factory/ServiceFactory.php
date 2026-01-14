<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\AbilityRepository;
use src\Repository\FeatRepository;
use src\Repository\ItemRepository;
use src\Repository\PowerRepository;
use src\Repository\OriginRepository;
use src\Repository\OriginAbility as RepositoryOriginAbility;
use src\Repository\OriginItem as RepositoryOriginItem;
use src\Repository\OriginSkill as RepositoryOriginSkill;
use src\Repository\SpeciesRepository;
use src\Repository\SpeciePower as RepositorySpeciePower;
use src\Repository\SubSkillRepository;
use src\Repository\SkillRepository;
use src\Repository\ToolRepository;
use src\Repository\WeaponRepository;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\ArmorReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\ItemReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\PowerReader;
use src\Service\Reader\SkillReader;
use src\Service\Reader\SpecieReader;
use src\Service\Reader\ToolReader;
use src\Service\Reader\WeaponReader;
use src\Service\FeatService;
use src\Service\OriginService;
use src\Service\SpecieService;
use src\Service\SkillService;

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
        $featRepo = new FeatRepository($this->queryBuilder, $this->queryExecutor);
        return new FeatReader($featRepo);
    }

    public function getOriginReader(): OriginReader
    {
        $originRepo = new OriginRepository($this->queryBuilder, $this->queryExecutor);
        return new OriginReader($originRepo);
    }

    public function getSpecieReader(): SpecieReader
    {
        $speciesRepo = new SpeciesRepository($this->queryBuilder, $this->queryExecutor);
        return new SpecieReader($speciesRepo);
    }
    
    public function getArmorReader(): ArmorReader
    {
        $repositoryFactory = new RepositoryFactory($this->queryBuilder, $this->queryExecutor);
        $readerFactory = new ReaderFactory($repositoryFactory);
        return $readerFactory->armor();
    }

    public function getToolReader(): ToolReader
    {
        $repo = new ToolRepository($this->queryBuilder, $this->queryExecutor);
        return new ToolReader($repo);
    }
    
    public function getWeaponReader(): WeaponReader
    {
        $repo = new WeaponRepository($this->queryBuilder, $this->queryExecutor);
        return new WeaponReader($repo);
    }

    public function getSkillReader(): SkillReader
    {
        $repo = new SkillRepository($this->queryBuilder, $this->queryExecutor);
        return new SkillReader($repo);
    }


    public function getAbilityReader(): AbilityReader
    {
        $repo = new AbilityRepository($this->queryBuilder, $this->queryExecutor);
        return new AbilityReader($repo);
    }

    public function origin(): OriginService
    {
        $featRepo     = new FeatRepository($this->queryBuilder, $this->queryExecutor);
        $toolRepo     = new ToolRepository($this->queryBuilder, $this->queryExecutor);
        $originSkillRepo    = new RepositoryOriginSkill($this->queryBuilder, $this->queryExecutor);
        $originAbilityRepo  = new RepositoryOriginAbility($this->queryBuilder, $this->queryExecutor);
        $originItemRepo     = new RepositoryOriginItem($this->queryBuilder, $this->queryExecutor);

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

    public function feat(): FeatService
    {
        return new FeatService();
    }

    public function specie(): SpecieService
    {
        $speciePowerRepo  = new RepositorySpeciePower($this->queryBuilder, $this->queryExecutor);
        $powerRepo  = new PowerRepository($this->queryBuilder, $this->queryExecutor);
        $powerReader = new PowerReader($powerRepo);

        return new SpecieService($speciePowerRepo, $powerReader);
    }

    public function skill(): SkillService
    {
        $subSkillRepo  = new SubSkillRepository($this->queryBuilder, $this->queryExecutor);

        return new SkillService($subSkillRepo);
    }
}
