<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class SpeciePowerCriteria extends BaseCriteria
{
    public ?int $speciesId = null;
    public ?int $powerId   = null;

    public array $orderBy = [
        F::ID => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->speciesId != null) {
            $filters[F::SPECIESID] = $this->speciesId;
        }
        if ($this->powerId != null) {
            $filters[F::POWERID] = $this->powerId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
