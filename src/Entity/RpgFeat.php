<?php
namespace src\Entity;

use src\Controller\RpgFeat as ControllerRpgFeat;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgFeatType as RepositoryRpgFeatType;

class RpgFeat extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected int $featTypeId
    ) {

    }

    public function getController(): ControllerRpgFeat
    {
        $controller = new ControllerRpgFeat;
        $controller->setField('rpgFeat', $this);
        return $controller;
    }
    
    public function getFeatType(): ?RpgFeatType
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgFeatType($queryBuilder, $queryExecutor);
        return $objDao->find($this->featTypeId);
    }
}
