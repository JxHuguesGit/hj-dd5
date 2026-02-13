<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class FeatCriteria extends BaseCriteria
{
    public ?int $featTypeId = null;
    public ?string $slug    = null;
    public ?string $name    = null;
    public ?string $nameLt  = null;
    public ?string $nameGt  = null;

    public array $orderBy   = [
        Field::NAME         => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->featTypeId!=null) {
            $filters[Field::FEATTYPEID] = $this->featTypeId;
        }
        if ($this->slug!=null) {
            $filters[Field::SLUG] = $this->slug;
        }
        if ($this->name!=null) {
            $filters[Field::NAME] = $this->name;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }
}
