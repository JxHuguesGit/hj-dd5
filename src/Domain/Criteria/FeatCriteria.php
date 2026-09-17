<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;

final class FeatCriteria extends BaseCriteria
{
    public const WPPOST_ALIAS = 'wp';

    #[Equals(F::ID, alias: 'f')]
    public ?int $id = null;

    #[Equals(field: 'post_title', alias: self::WPPOST_ALIAS)]
    public ?string $name = null;

    #[Equals(field:'post_name', alias: self::WPPOST_ALIAS)]
    public ?string $slug = null;

    #[Equals(F::FEATTYPEID)]
    public ?int $featTypeId = null;

    #[Equals(F::SOURCEID)]
    public ?int $sourceId = null;

    #[Compare(field: 'post_title', operator: Compare::LT, alias: self::WPPOST_ALIAS)]
    public ?string $nameLt = null;

    #[Compare(field: 'post_title', operator: Compare::GT, alias: self::WPPOST_ALIAS)]
    public ?string $nameGt = null;

    public array $orderBy = [
        F::FEATTYPEID => C::ASC,
        self::WPPOST_ALIAS . '.post_title' => C::ASC
    ];
}
