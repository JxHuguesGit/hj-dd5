<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgClasseSkill as RepositoryRpgSkill;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgClasseSkill extends Entity
{
    public const TABLE = 'rpgClasseSkill';
    public const FIELDS = [
        Field::ID,
        Field::CLASSEID,
        Field::SKILLID,
    ];

    protected int $classeId;
    protected int $skillId;
    
    public function getSkill(): ?RpgSkill
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgSkill($queryBuilder, $queryExecutor);
        return $objDao->find($this->skillId);
    }
}
