<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class OriginItemCriteria extends BaseCriteria
{
    public ?int $originId = null;
    public ?int $itemId   = null;

    public array $orderBy = [
        F::ID => Constant::ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->originId != null) {
            $filters[F::ORIGINID] = $this->originId;
        }
        if ($this->itemId != null) {
            $filters[F::ITEMID] = $this->itemId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
