<?php
namespace src\Entity;

use src\Entity\RpgLanguage as EntityRpgLanguage;
use src\Repository\RpgLanguage;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgJoinMonsterLanguage extends Entity
{

    public function __construct(
        protected int $id,
        protected int $monsterId,
        protected string $languageId
    ) {

    }

    public function getLanguage(): ?EntityRpgLanguage
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgLanguage($queryBuilder, $queryExecutor);
        return $objDao->find($this->languageId);
    }
}