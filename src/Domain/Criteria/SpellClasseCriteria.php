<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class SpellClasseCriteria extends BaseCriteria
{
    #[Equals(F::SPELLID)]
    public ?int $spellId = null;

    #[Equals(F::CLASSEID)]
    public ?int $classeId = null;

    public array $orderBy = [
        F::ID => C::ASC,
    ];
}
