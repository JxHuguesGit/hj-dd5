<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class MonsterAbilityCriteria extends BaseCriteria
{
    public ?string $typeId = null;
    public ?int $monsterId = null;
    public ?int $powerId   = null;

    public array $orderBy = [
        F::RANK => C::ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->typeId != null) {
            $filters[F::TYPEID] = $this->typeId;
        }
        if ($this->monsterId != null) {
            $filters[F::MONSTERID] = $this->monsterId;
        }
        if ($this->powerId != null) {
            $filters[F::POWERID] = $this->powerId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
