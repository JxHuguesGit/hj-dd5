<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class OriginAbilityCriteria extends BaseCriteria
{
    #[Equals(F::ORIGINID)]
    public ?int $originId = null;

    #[Equals(F::ABILITYID)]
    public ?int $abilityId = null;

    public array $orderBy = [
        F::ID => C::ASC,
    ];
}
