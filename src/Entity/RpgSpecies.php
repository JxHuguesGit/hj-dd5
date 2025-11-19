<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgSpecies as ControllerRpgSpecies;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;

class RpgSpecies extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected int $parentId,
    ) {

    }

    public function getController(): ControllerRpgSpecies
    {
        $controller = new ControllerRpgSpecies();
        $controller->setField('rpgSpecies', $this);
        return $controller;
    }

    public function getFullName(): string
    {
        if ($this->parentId==0) {
            return $this->name;
        } else {
            return $this->getSpecies()->getFullName().' ('.$this->name.')';
        }
    }

    public function getSpecies(): ?RpgSpecies
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoSpecies = new RepositoryRpgSpecies($queryBuilder, $queryExecutor);
        return $objDaoSpecies->find($this->{Field::PARENTID});
    }
}
