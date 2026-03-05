<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class AbilityCriteria extends BaseCriteria
{
    public ?string $name   = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        F::ID => Constant::ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->name != null) {
            $filters[F::NAME] = $this->name;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, F::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, F::NAME, $this->nameGt);
    }
}
