<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgSkill as ControllerRpgSkill;
use src\Entity\RpgAbility;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgAbility as RepositoryRpgAbility;
use src\Repository\RpgSubSkill as RepositoryRpgSubSkill;

class RpgSkill extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected int $abilityId
    ) {

    }

    public function getController(): ControllerRpgSkill
    {
        $controller = new ControllerRpgSkill;
        $controller->setField('rpgSkill', $this);
        return $controller;
    }

    public function getAbility(): ?RpgAbility
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgAbility($queryBuilder, $queryExecutor);
        return $objDao->find($this->abilityId);
    }
    
    public function getSubSkills(): \Iterator
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgSubSkill($queryBuilder, $queryExecutor);
        return $objDao->findBy([Field::SKILLID=>$this->id], [Field::NAME=>'ASC']);
    }
}
