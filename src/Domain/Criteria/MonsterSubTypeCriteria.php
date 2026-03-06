<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class MonsterSubTypeCriteria extends BaseCriteria
{
    public ?int $monstreTypeId = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        F::NAME => C::ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->monstreTypeId!=null) {
            $filters[F::MSTTYPEID] = $this->monstreTypeId;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, F::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, F::NAME, $this->nameGt);
    }
}
