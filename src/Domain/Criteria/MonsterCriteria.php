<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;

final class MonsterCriteria extends BaseCriteria
{
    public int $page = 1;
    public string $type = 'append';

    #[Equals(F::ID)]
    public ?int $id = null;

    #[Equals(F::UKTAG)]
    public ?string $ukTag = null;

    #[Compare(field: F::NAME, operator: Compare::LT)]
    public ?string $nameLt = null;

    #[Compare(field: F::NAME, operator: Compare::GT)]
    public ?string $nameGt = null;

    public array $orderBy = [
        'CONCAT('.F::FRNAME.', m.'.F::NAME.')' => C::ASC
    ];

    public static function fromRequest(array $request): self
    {
        // Voir SpellCriteria pour informations complémentaires.
        $criteria = new self();
        $criteria->orderBy = [F::NAME => C::ASC];
        $criteria->page = (int)($request['page'] ?? 1);
        $criteria->limit = (int)($request['limit'] ?? 10);
        $criteria->offset = $criteria->page*$criteria->limit;
        $criteria->type = $request[C::TYPE] ?? 'append';
        return $criteria;
    }

}
