<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class MonsterSpeedTypeCriteria extends BaseCriteria
{
    public ?int $monsterId = null;

    public array $orderBy = [
        Field::TYPESPEEDID => Constant::CST_ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->monsterId!=null) {
            $filters[Field::MONSTERID] = $this->monsterId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
