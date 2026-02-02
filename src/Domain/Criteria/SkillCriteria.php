<?php
namespace src\Domain\Criteria;

use src\Constant\Field;
use src\Query\QueryBuilder;

final class SkillCriteria extends AbstractCriteria implements CriteriaInterface
{
    public ?string $slug = null;
    public ?int $abilityId = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        $filters[Field::ABILITYID] = $this->abilityId;
        if ($this->slug!=null) {
            $filters[Field::SLUG] = $this->slug;
        }

        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }
}
