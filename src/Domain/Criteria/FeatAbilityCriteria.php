<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class FeatAbilityCriteria extends BaseCriteria
{
    public ?int $featId    = null;
    public ?int $abilityId = null;

    public array $orderBy = [
        F::ID => Constant::ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->featId != null) {
            $filters[F::FEATID] = $this->featId;
        }
        if ($this->abilityId != null) {
            $filters[F::ABILITYID] = $this->abilityId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
