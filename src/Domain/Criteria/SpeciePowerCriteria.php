<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class SpeciePowerCriteria extends BaseCriteria
{
    #[Equals(F::SPECIESID)]
    public ?int $speciesId = null;

    #[Equals(F::POWERID)]
    public ?int $powerId = null;

    public array $orderBy = [
        F::ID => C::ASC,
    ];
}
