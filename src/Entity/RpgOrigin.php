<?php
namespace src\Entity;

use src\Controller\RpgOrigin as ControllerRpgOrigin;
use src\Enum\AbilityEnum;
use src\Enum\SkillEnum;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgFeat as RepositoryRpgFeat;

class RpgOrigin extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected string $caracEnums,
        protected int $featId,
        protected string $skillEnums,
        protected int $toolId
    ) {

    }

    public function getController(): ControllerRpgOrigin
    {
        $controller = new ControllerRpgOrigin();
        $controller->setField('rpgOrigin', $this);
        return $controller;
    }
    
    public function getCaracteristiques(): string
    {
        $caracs = [];
        $lstEnums = explode(',', $this->caracEnums);
        foreach ($lstEnums as $key) {
            $caracs[] = AbilityEnum::fromDb($key);
        }
        return implode(', ', $caracs);
    }
    
    public function getSkills(): string
    {
        $caracs = [];
        $lstEnums = explode(',', $this->skillEnums);
        foreach ($lstEnums as $key) {
            $caracs[] = SkillEnum::fromDb($key);
        }
        return implode(', ', $caracs);
    }
    
    public function getOriginFeat(): ?RpgFeat
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgFeat($queryBuilder, $queryExecutor);
        return $objDao->find($this->featId);
    }
    
}
