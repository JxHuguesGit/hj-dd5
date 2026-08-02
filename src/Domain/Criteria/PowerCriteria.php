<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class PowerCriteria extends BaseCriteria
{
    #[Equals(F::PARENTID)]
    public ?int $parentId = null;

    public array $orderBy = [
        F::ID => C::ASC,
    ];
}
