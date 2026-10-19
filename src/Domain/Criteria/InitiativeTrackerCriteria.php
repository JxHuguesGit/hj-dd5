<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class InitiativeTrackerCriteria extends BaseCriteria
{
    #[Equals(F::ITCODE)]
    public ?string $iTCode = null;

    public array $orderBy = [
        F::ID => C::ASC
    ];
}
