<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;

final class WeaponCriteria extends BaseCriteria
{
    #[Equals(F::ID)]
    public ?int $id = null;

    #[Equals(F::TYPE)]
    public string $type = C::WEAPON;

    #[Equals(F::NAME)]
    public ?string $name = null;

    #[Equals(field: F::SLUG, alias: 'i')]
    public ?string $slug = null;

    #[Equals(field: F::WPNCATID)]
    public ?int $weaponCategoryId = null;

    #[Equals(field: F::WPNRANGEID)]
    public ?int $weaponRangeId = null;

    #[Compare(field: F::NAME, operator: Compare::LT, alias: 'i')]
    public ?string $nameLt = null;

    #[Compare(field: F::NAME, operator: Compare::GT, alias: 'i')]
    public ?string $nameGt = null;

    public array $orderBy = [
        F::WPNCATID   => C::ASC,
        F::WPNRANGEID => C::ASC,
        'i.'.F::NAME       => C::ASC,
    ];
}
