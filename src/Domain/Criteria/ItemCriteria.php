<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;

final class ItemCriteria extends BaseCriteria
{
    #[Equals(F::ID)]
    public ?int $id = null;

    #[Equals(F::TYPE, alias: 'i')]
    public ?string $type = C::OTHER;

    #[Equals(F::NAME, alias: 'i')]
    public ?string $name = null;

    #[Equals(F::SLUG, alias: 'i')]
    public ?string $slug = null;

    #[Equals(F::TOOLID, alias: 'i')]
    public ?int $toolId = null;

    #[Compare(field: F::NAME, alias: 'i', operator: Compare::LT)]
    public ?string $nameLt = null;

    #[Compare(field: F::NAME, alias: 'i', operator: Compare::GT)]
    public ?string $nameGt = null;

    public array $orderBy = [
        F::NAME => C::ASC,
    ];
}
