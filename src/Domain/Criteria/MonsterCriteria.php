<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class MonsterCriteria extends AbstractCriteria implements CriteriaInterface
{
    public int $page = 1;
    public string $type = 'append';

    public int $offset = 1;
    public int $limit = 10;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        Field::NAME => Constant::CST_ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }

    public static function fromRequest(array $request): self
    {
        // Voir SpellCriteria pour informations complémentaires.
        $criteria = new self();
        $criteria->orderBy = [Field::NAME => Constant::CST_ASC];
        $criteria->page = (int)($request['page'] ?? 1);
        $criteria->limit = (int)($request['limit'] ?? 10);
        $criteria->offset = $criteria->page*$criteria->limit+1;
        $criteria->type = $request[Constant::CST_TYPE] ?? 'append';
        return $criteria;
    }

}
