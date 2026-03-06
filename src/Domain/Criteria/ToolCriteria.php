<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class ToolCriteria extends BaseCriteria
{
    public ?int $id = null;
    public string $type = C::TOOL;
    public ?string $name = null;

    public array $orderBy = [
        F::PARENTID => C::ASC,
        F::NAME     => C::ASC,
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
        if ($this->name !== null) {
            $filters[F::NAME] = $this->name;
        }
        $this->applyEquals($qb, $filters);
    }
}
