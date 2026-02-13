<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class ItemCriteria extends BaseCriteria
{
    public ?int $id = null;
    public ?string $type  = 'other';
    public ?string $slug = null;
    public ?string $name = null;
    
    public array $orderBy = [
        Field::NAME => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $qb): void
    {
        $filters = [];
        if ($this->id !== null) {
            $filters[Field::ID] = $this->id;
        }
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
