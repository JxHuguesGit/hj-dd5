<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class WeaponPropertyValueCriteria extends BaseCriteria
{
    public ?int $weaponId = null;

    public array $orderBy = [
        Field::NAME => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->weaponId !== null) {
            $filters[Field::WEAPONID] = $this->weaponId;
        }

        $this->applyEquals($queryBuilder, $filters);
    }
}
