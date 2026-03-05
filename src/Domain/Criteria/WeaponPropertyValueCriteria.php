<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class WeaponPropertyValueCriteria extends BaseCriteria
{
    public ?int $weaponId = null;

    public array $orderBy = [
        F::NAME => Constant::ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->weaponId !== null) {
            $filters[F::WEAPONID] = $this->weaponId;
        }

        $this->applyEquals($queryBuilder, $filters);
    }
}
