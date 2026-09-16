<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;

final class SkillCriteria extends BaseCriteria
{
    public const WPPOST_ALIAS = 'wp';

    #[Equals(field: F::ID, alias : 's')]
    public ?int $id = null;

    #[Equals(field: 'post_title', alias: self::WPPOST_ALIAS)]
    public ?string $name = null;

    #[Equals(field: 'post_name', alias: self::WPPOST_ALIAS)]
    public ?string $slug = null;

    #[Equals(field: F::ABILITYID)]
    public ?int $abilityId = null;

    #[Equals(field: F::PARENTID)]
    public ?string $parentId = null;

    #[Compare(field: F::PARENTID, operator: Compare::IS_NULL)]
    public ?bool $parentIdIsNull = null;

    #[Compare(field: 'post_title', operator: Compare::LT, alias: self::WPPOST_ALIAS)]
    public ?string $nameLt = null;

    #[Compare(field: 'post_title', operator: Compare::GT, alias: self::WPPOST_ALIAS)]
    public ?string $nameGt = null;

    public array $orderBy = [
        F::ABILITYID => C::ASC,
        self::WPPOST_ALIAS . '.post_title' => C::ASC
    ];
}
