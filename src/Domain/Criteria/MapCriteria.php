<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class MapCriteria extends BaseCriteria
{
    #[Equals(F::ID)]
    public ?int $id = null;

    #[Equals(F::ACTIVE)]
    public ?int $active = null;

    public array $orderBy = [
        F::NAME => C::ASC
    ];
}
