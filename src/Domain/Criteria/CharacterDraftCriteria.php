<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class CharacterDraftCriteria extends BaseCriteria
{
    public ?string $name    = null;
    public ?int $wpUserId   = null;

    public array $orderBy   = [
        Field::NAME         => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->wpUserId!=null) {
            $filters[Field::WPUSERID] = $this->wpUserId;
        }
        if ($this->name!=null) {
            $filters[Field::NAME] = $this->name;
        }
        $this->applyEquals($queryBuilder, $filters);
    }
}
