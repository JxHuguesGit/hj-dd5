<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class MonsterAbilityCriteria extends BaseCriteria
{
    public ?string $typeId = null;
    public ?int $monsterId = null;
    public ?int $powerId   = null;

    public array $orderBy = [
        Field::RANK => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->typeId != null) {
            $filters[Field::TYPEID] = $this->typeId;
        }
        if ($this->monsterId != null) {
            $filters[Field::MONSTERID] = $this->monsterId;
        }
        if ($this->powerId != null) {
            $filters[Field::POWERID] = $this->powerId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
