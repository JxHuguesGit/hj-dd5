<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class OriginItemCriteria extends BaseCriteria
{
    public ?int $originId = null;
    public ?int $itemId   = null;

    public array $orderBy = [
        Field::ID => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->originId != null) {
            $filters[Field::ORIGINID] = $this->originId;
        }
        if ($this->itemId != null) {
            $filters[Field::ITEMID] = $this->itemId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
