<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class WeaponCriteria extends AbstractCriteria implements CriteriaInterface
{
    public string $type = Constant::CST_WEAPON;
    public ?string $name = null;
    public ?string $slug = null;
    public ?string $nameLt  = null;
    public ?string $nameGt  = null;

    public array $orderBy = [
        Field::WPNCATID   => Constant::CST_ASC,
        Field::WPNRANGEID => Constant::CST_ASC,
        'i.'.Field::NAME       => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $qb): void
    {
        $filters = [];
        if ($this->type !== null) {
            $filters[Field::TYPE] = $this->type;
        }
        if ($this->slug !== null) {
            $filters['i.'.Field::SLUG] = $this->slug;
        }
        if ($this->name !== null) {
            $filters['i.'.Field::NAME] = $this->name;
        }
        $this->applyEquals($qb, $filters);
        $this->applyLt($qb, 'i.'.Field::NAME, $this->nameLt);
        $this->applyGt($qb, 'i.'.Field::NAME, $this->nameGt);
    }
}
