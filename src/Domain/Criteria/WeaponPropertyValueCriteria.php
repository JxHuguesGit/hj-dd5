<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class WeaponPropertyValueCriteria extends BaseCriteria
{
    #[Equals(F::TYPEID)]
    public ?int $typeId = null;

    #[Equals(F::WEAPONID)]
    public ?int $weaponId = null;

    public array $orderBy = [
        F::RANK => C::ASC,
    ];
}
