<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class SubSkillCriteria extends BaseCriteria
{
    public ?int $skillId   = null;
    public ?string $slug   = null;
    public ?string $name   = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        F::NAME => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->skillId != null) {
            $filters[F::SKILLID] = $this->skillId;
        }
        if ($this->slug != null) {
            $filters[F::SLUG] = $this->slug;
        }
        if ($this->name != null) {
            $filters[F::NAME] = $this->name;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, F::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, F::NAME, $this->nameGt);
    }
}
