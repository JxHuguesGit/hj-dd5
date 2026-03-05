<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class ItemCriteria extends BaseCriteria
{
    public ?int $id = null;
    public ?string $type  = 'other';
    public ?string $slug = null;
    public ?string $name = null;

    public array $orderBy = [
        F::NAME => Constant::CST_ASC,
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
        if ($this->slug!=null) {
            $filters[F::SLUG] = $this->slug;
        }
        if ($this->name !== null) {
            $filters[F::NAME] = $this->name;
        }
        $this->applyEquals($qb, $filters);
    }
}
