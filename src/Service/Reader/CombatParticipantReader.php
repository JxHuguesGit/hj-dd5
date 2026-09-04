<?php

namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\CombatParticipantCriteria;
use src\Domain\Entity\CombatParticipant;
use src\Repository\CombatParticipantRepositoryInterface;

final class CombatParticipantReader
{
    public function __construct(
        private CombatParticipantRepositoryInterface $combatParticipantRepository,
    ) {}

    /**
     * @return ?CombatParticipant
     */
    public function participantById(int $id): ?CombatParticipant
    {
        return $this->combatParticipantRepository->find($id);
    }

    /**
     * @return Collection<CombatParticipant>
     */
    public function participantsByCombat(int $combatId): Collection
    {
        $criteria = new CombatParticipantCriteria();
        $criteria->combatId = $combatId;

        return $this->combatParticipantRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<CombatParticipant>
     */
    public function participantsByToken(int $tokenId): Collection
    {
        $criteria = new CombatParticipantCriteria();
        $criteria->tokenId = $tokenId;

        return $this->combatParticipantRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<CombatParticipant>
     */
    public function participantsByMapToken(int $mapTokenId): Collection
    {
        $criteria = new CombatParticipantCriteria();
        $criteria->mapTokenId = $mapTokenId;

        return $this->combatParticipantRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<CombatParticipant>
     */
    public function allCombatParticipants(?CombatParticipantCriteria $criteria = null): Collection
    {
        if ($criteria === null) {
            $criteria = new CombatParticipantCriteria();
        }

        return $this->combatParticipantRepository->findAllWithCriteria($criteria);
    }
}
