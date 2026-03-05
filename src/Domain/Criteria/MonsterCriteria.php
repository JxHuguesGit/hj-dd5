<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class MonsterCriteria extends BaseCriteria
{
    public int $page = 1;
    public string $type = 'append';

    public ?int $id = null;
    public ?string $ukTag = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        'CONCAT('.F::FRNAME.', m.'.F::NAME.')' => Constant::CST_ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->id!=null) {
            $filters[F::ID] = $this->id;
        }
        if ($this->ukTag!=null) {
            $filters[F::UKTAG] = $this->ukTag;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, F::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, F::NAME, $this->nameGt);
    }

    public static function fromRequest(array $request): self
    {
        // Voir SpellCriteria pour informations complémentaires.
        $criteria = new self();
        $criteria->orderBy = [F::NAME => Constant::CST_ASC];
        $criteria->page = (int)($request['page'] ?? 1);
        $criteria->limit = (int)($request['limit'] ?? 10);
        $criteria->offset = $criteria->page*$criteria->limit;
        $criteria->type = $request[Constant::CST_TYPE] ?? 'append';
        return $criteria;
    }

}
