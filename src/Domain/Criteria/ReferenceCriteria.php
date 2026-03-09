<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;

final class ReferenceCriteria extends BaseCriteria
{
    #[Equals(F::ID)]
    public ?int $id = null;

    #[Equals(F::SLUG)]
    public ?string $slug = null;

    #[Compare(field: F::NAME, operator: Compare::LT)]
    public ?string $nameLt = null;

    #[Compare(field: F::NAME, operator: Compare::GT)]
    public ?string $nameGt = null;

    public array $orderBy = [
        F::NAME => C::ASC
    ];
}
