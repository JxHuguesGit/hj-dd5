<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class WeaponCriteria extends BaseCriteria
{
    public ?int $id = null;
    public string $type = Constant::CST_WEAPON;
    public ?string $name = null;
    public ?string $slug = null;
    public ?string $nameLt  = null;
    public ?string $nameGt  = null;

    public array $orderBy = [
        F::WPNCATID   => Constant::CST_ASC,
        F::WPNRANGEID => Constant::CST_ASC,
        'i.'.F::NAME       => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $qb): void
    {
        $filters = [];
        if ($this->id !== null) {
            $filters[F::ID] = $this->id;
        }
        if ($this->type !== null) {
            $filters[F::TYPE] = $this->type;
        }
        if ($this->slug !== null) {
            $filters['i.'.F::SLUG] = $this->slug;
        }
        if ($this->name !== null) {
            $filters['i.'.F::NAME] = $this->name;
        }
        $this->applyEquals($qb, $filters);
        $this->applyLt($qb, 'i.'.F::NAME, $this->nameLt);
        $this->applyGt($qb, 'i.'.F::NAME, $this->nameGt);
    }
}
