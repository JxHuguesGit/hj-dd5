<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class SkillCriteria extends BaseCriteria
{
    public ?string $slug = null;
    public ?int $abilityId = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        F::NAME => C::ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->slug!=null) {
            $filters[F::SLUG] = $this->slug;
        }
        if ($this->abilityId!=null) {
            $filters[F::ABILITYID] = $this->abilityId;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, F::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, F::NAME, $this->nameGt);
    }
}
