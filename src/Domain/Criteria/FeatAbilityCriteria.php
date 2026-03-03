<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class FeatAbilityCriteria extends BaseCriteria
{
    public ?int $featId    = null;
    public ?int $abilityId = null;

    public array $orderBy = [
        Field::ID => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->featId != null) {
            $filters[Field::FEATID] = $this->featId;
        }
        if ($this->abilityId != null) {
            $filters[Field::ABILITYID] = $this->abilityId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
