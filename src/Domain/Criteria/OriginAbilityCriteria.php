<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class OriginAbilityCriteria extends BaseCriteria
{
    public ?int $originId  = null;
    public ?int $abilityId = null;

    public array $orderBy = [
        Field::ID => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->originId != null) {
            $filters[Field::ORIGINID] = $this->originId;
        }
        if ($this->abilityId != null) {
            $filters[Field::ABILITYID] = $this->abilityId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
