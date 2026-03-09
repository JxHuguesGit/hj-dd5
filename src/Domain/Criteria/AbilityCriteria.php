<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class AbilityCriteria extends BaseCriteria
{
    #[Equals(F::NAME)]
    public ?string $name = null;

    #[Equals(F::SLUG)]
    public ?string $slug = null;

    public array $orderBy = [
        F::ID => C::ASC,
    ];
}
