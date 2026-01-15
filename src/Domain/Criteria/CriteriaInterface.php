<?php
namespace src\Domain\Criteria;

use src\Query\QueryBuilder;

interface CriteriaInterface
{
    public function apply(QueryBuilder $queryBuilder): void;
}
