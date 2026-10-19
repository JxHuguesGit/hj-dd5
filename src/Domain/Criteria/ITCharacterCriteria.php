<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class ITCharacterCriteria extends BaseCriteria
{
    #[Equals(F::ITID)]
    public ?int $initiativeTrackerId = null;

    public array $orderBy = [
        F::NAME => C::ASC
    ];
}