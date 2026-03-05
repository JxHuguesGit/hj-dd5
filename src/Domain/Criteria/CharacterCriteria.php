<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class CharacterCriteria extends BaseCriteria
{
    public ?string $name  = null;
    public ?int $wpUserId = null;

    public array $orderBy = [
        F::NAME => Constant::ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->wpUserId != null) {
            $filters[F::WPUSERID] = $this->wpUserId;
        }
        if ($this->name != null) {
            $filters[F::NAME] = $this->name;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
