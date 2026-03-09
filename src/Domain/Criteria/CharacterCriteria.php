<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class CharacterCriteria extends BaseCriteria
{
    #[Equals(F::ID)]
    public ?int $id = null;

    #[Equals(F::WPUSERID)]
    public ?int $wpUserId = null;

    #[Equals(F::NAME)]
    public ?string $name = null;

    public array $orderBy = [
        F::NAME => C::ASC,
    ];
}
