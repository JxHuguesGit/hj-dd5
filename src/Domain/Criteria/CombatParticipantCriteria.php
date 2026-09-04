<?php

namespace src\Domain\Criteria;

use src\Constant\Field as F;
use src\Domain\Criteria\Attributes\Equals;

final class CombatParticipantCriteria extends AbstractCriteria
{
    public function __construct(
        #[Equals(F::ID)]
        public ?int $id = null,

        #[Equals(F::COMBATID)]
        public ?int $combatId = null,

        #[Equals(F::TOKENID)]
        public ?int $tokenId = null,

        #[Equals(F::MAPTOKENID)]
        public ?int $mapTokenId = null,
    ) {
        $this->orderBy = [
            F::INITIATIVE => 'DESC',
        ];
    }
}
