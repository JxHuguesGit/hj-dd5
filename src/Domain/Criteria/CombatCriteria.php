<?php

namespace src\Domain\Criteria;

use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class CombatCriteria extends AbstractCriteria
{
    public function __construct(
        #[Equals(F::WPUSERID)]
        public ?int $wpUserId = null,

        #[Equals(F::MAPID)]
        public ?int $mapId = null,

        #[Equals(F::ACTIVE)]
        public ?int $active = null,
    ) {
    }
}
