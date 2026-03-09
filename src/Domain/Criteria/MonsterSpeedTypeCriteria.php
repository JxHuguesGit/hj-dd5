<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class MonsterSpeedTypeCriteria extends BaseCriteria
{
    #[Equals(F::MONSTERID)]
    public ?int $monsterId = null;

    public array $orderBy = [
        F::TYPESPEEDID => C::ASC,
    ];
}
