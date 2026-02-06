<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class ItemCriteria extends AbstractCriteria implements CriteriaInterface
{
    public string $type  = 'other';
    public ?string $slug = null;
    public ?string $name = null;
    
    public array $orderBy = [
        Field::NAME => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $qb): void
    {
        $filters = [];
        if ($this->type !== null) {
            $filters[Field::TYPE] = $this->type;
        }
        if ($this->slug!=null) {
            $filters[Field::SLUG] = $this->slug;
        }
        if ($this->name !== null) {
            $filters[Field::NAME] = $this->name;
        }
        $this->applyEquals($qb, $filters);
    }
}
