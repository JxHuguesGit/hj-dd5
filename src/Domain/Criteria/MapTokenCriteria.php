<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class MapTokenCriteria extends BaseCriteria
{
    #[Equals(F::ID, alias: 'mp')]
    public ?int $id = null;

    #[Equals(F::MAPID)]
    public ?int $mapId = null;

    #[Equals(F::TOKENID)]
    public ?int $tokenId = null;

    #[Equals(F::ACTIVE, alias: 'mp')]
    public ?int $active = null;

    #[Equals(F::SIZE, alias: 'mp')]
    public ?int $size = null;

    public array $orderBy = [
        F::NAME => C::ASC
    ];
}
