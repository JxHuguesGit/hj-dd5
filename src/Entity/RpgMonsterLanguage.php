<?php
namespace src\Entity;

use src\Controller\RpgMonsterLanguage as ControllerRpgMonsterLanguage;
use src\Entity\RpgLanguage as EntityRpgLanguage;
use src\Repository\RpgLanguage;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterLanguage extends Entity
{

    public function __construct(
        protected int $id,
        protected int $monsterId,
        protected string $languageId,
        protected float $value,
    ) {

    }
    
    public function getController(): ControllerRpgMonsterLanguage
    {
        $obj = new ControllerRpgMonsterLanguage();
        $obj->setField('rpgMonsterLanguage', $this);
        return $obj;
    }

    public function getLanguage(): ?EntityRpgLanguage
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgLanguage($queryBuilder, $queryExecutor);
        return $objDao->find($this->languageId);
    }
}
