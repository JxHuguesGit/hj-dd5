<?php

namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;

final class MonsterCriteria extends BaseCriteria
{
    #[Equals(F::ID, alias: 'm')]
    public ?int $id = null;

    #[Equals(F::UKTAG)]
    public ?string $ukTag = null;

    #[Compare(field: F::NAME, alias: 'm', operator: Compare::LIKE)]
    public ?string $name = null;

    #[Equals(F::REFID)]
    public ?int $referenceId = null;

    #[Equals(F::SCORECR)]
    public ?float $cr = null;

    public array $orderBy = [
        F::NAME => C::ASC,
    ];
}
