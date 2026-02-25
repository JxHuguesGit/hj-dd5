<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class OriginSkillCriteria extends BaseCriteria
{
    public ?int $originId = null;
    public ?int $skillId  = null;

    public array $orderBy = [
        Field::ID => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->originId != null) {
            $filters[Field::ORIGINID] = $this->originId;
        }
        if ($this->skillId != null) {
            $filters[Field::SKILLID] = $this->skillId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
