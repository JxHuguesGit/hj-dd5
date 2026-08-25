<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class MapFogCriteria extends BaseCriteria
{
    #[Equals(F::ID)]
    public ?int $id = null;

    #[Equals(F::MAPID)]
    public ?int $mapId = null;

    #[Equals(F::MAPCOLUMN)]
    public ?int $mapColumn = null;

    #[Equals(F::MAPROW)]
    public ?int $mapRow = null;

    public array $orderBy = [
        F::MAPCOLUMN => C::ASC,
        F::MAPROW => C::ASC
    ];
}
