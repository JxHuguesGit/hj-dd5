<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class SkillCriteria extends AbstractCriteria implements CriteriaInterface
{
    public ?string $slug = null;
    public ?int $abilityId = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        Field::NAME => Constant::CST_ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->slug!=null) {
            $filters[Field::SLUG] = $this->slug;
        }
        if ($this->abilityId!=null) {
            $filters[Field::ABILITYID] = $this->abilityId;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }
}
