<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class MonsterAbilityCriteria extends BaseCriteria
{
    #[Equals(F::TYPEID)]
    public ?int $typeId = null;

    #[Equals(F::MONSTERID)]
    public ?int $monsterId = null;

    #[Equals(F::POWERID)]
    public ?int $powerId = null;

    public array $orderBy = [
        F::RANK => C::ASC,
    ];
}
