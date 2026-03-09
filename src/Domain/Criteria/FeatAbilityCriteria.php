<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class FeatAbilityCriteria extends BaseCriteria
{
    #[Equals(F::FEATID)]
    public ?int $featId = null;

    #[Equals(F::ABILITYID)]
    public ?int $abilityId = null;

    public array $orderBy = [
        F::ID => C::ASC,
    ];
}
