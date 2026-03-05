<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class MonsterVisionTypeCriteria extends BaseCriteria
{
    public ?int $monsterId = null;

    public array $orderBy = [
        F::ID => Constant::ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->monsterId != null) {
            $filters[F::MONSTERID] = $this->monsterId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
