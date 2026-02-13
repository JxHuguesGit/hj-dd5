<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class ToolCriteria extends BaseCriteria
{
    public ?int $id = null;
    public string $type = Constant::CST_TOOL;
    public ?string $name = null;
    
    public array $orderBy = [
        Field::PARENTID => Constant::CST_ASC,
        Field::NAME     => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $qb): void
    {
        $filters = [];
        if ($this->id !== null) {
            $filters[Field::ID] = $this->id;
        }
        if ($this->type !== null) {
            $filters[Field::TYPE] = $this->type;
        }
        if ($this->name !== null) {
            $filters[Field::NAME] = $this->name;
        }
        $this->applyEquals($qb, $filters);
    }
}
