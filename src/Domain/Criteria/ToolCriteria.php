<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;

final class ToolCriteria extends BaseCriteria
{
    #[Equals(F::ID)]
    public ?int $id = null;

    #[Equals(F::TYPE, alias: 'i')]
    public string $type = C::TOOL;

    #[Equals(F::NAME, alias: 'i')]
    public ?string $name = null;

    #[Equals(F::SLUG, alias: 'i')]
    public ?string $slug = null;

    #[Equals(F::PARENTID)]
    public ?int $parentId = null;

    #[Compare(field: F::NAME, operator: Compare::LT, alias: 'i')]
    public ?string $nameLt = null;

    #[Compare(field: F::NAME, operator: Compare::GT, alias: 'i')]
    public ?string $nameGt = null;

    public array $orderBy = [
        F::PARENTID => C::ASC,
        'i.'.F::NAME     => C::ASC,
    ];
}
