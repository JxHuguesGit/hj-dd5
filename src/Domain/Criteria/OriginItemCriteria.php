<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class OriginItemCriteria extends BaseCriteria
{
    #[Equals(F::ORIGINID)]
    public ?int $originId = null;

    #[Equals(F::ITEMID)]
    public ?int $itemId = null;

    public array $orderBy = [
        F::ID => C::ASC,
    ];
}
