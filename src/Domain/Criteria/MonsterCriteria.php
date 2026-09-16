<?php

namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;

final class MonsterCriteria extends BaseCriteria
{
    public int $page               = 1;
    public string $type            = 'append';

    #[Equals(F::ID, alias: 'm')]
    public ?int $id = null;

    #[Equals(F::UKTAG)]
    public ?string $ukTag = null;

    #[Compare(field: F::NAME, alias: 'm', operator: Compare::LIKE)]
    public ?string $name = null;

    #[Equals(F::REFID)]
    public ?int $referenceId = null;

    #[Equals(F::SCORECR)]
    public ?float $cr = null;

    public array $orderBy = [
        F::NAME => C::ASC,
    ];

    /**
     * Instancie MonsterCriteria depuis $_POST ou un tableau
     */
    public static function fromRequest(array $request): self
    {
        $criteria              = new self();
        $criteria->page        = (int) ($request['page'] ?? 1);
        $criteria->type        = $request[C::TYPE] ?? 'append';
        $criteria->id          = (int) ($request['id'] ?? 1);
        $criteria->ukTag       = $request['ukTag'] ?? '';
        $criteria->name        = $request['name'] ?? '';
        $criteria->referenceId = (int) ($request['referenceId'] ?? 0);
        $criteria->cr          = $request['cr'] ?? '';

        return $criteria;
    }
}
