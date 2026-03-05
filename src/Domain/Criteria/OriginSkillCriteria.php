<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class OriginSkillCriteria extends BaseCriteria
{
    public ?int $originId = null;
    public ?int $skillId  = null;

    public array $orderBy = [
        F::ID => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->originId != null) {
            $filters[F::ORIGINID] = $this->originId;
        }
        if ($this->skillId != null) {
            $filters[F::SKILLID] = $this->skillId;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
