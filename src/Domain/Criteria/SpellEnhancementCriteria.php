<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class SpellEnhancementCriteria extends BaseCriteria
{
    #[Equals(F::ID)]
    public ?int $id = null;

    #[Equals(F::TYPE)]
    public ?string $type = null;

    public array $orderBy = [
        F::DESCRIPTION => C::ASC
    ];
}
