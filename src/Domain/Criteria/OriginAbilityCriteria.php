<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class OriginAbilityCriteria extends BaseCriteria
{
    public ?int $originId  = null;
    public ?int $abilityId = null;

    public array $orderBy = [
        F::ID => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->originId != null) {
            $filters[F::ORIGINID] = $this->originId;
        }
        if ($this->abilityId != null) {
            $filters[F::ABILITYID] = $this->abilityId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
