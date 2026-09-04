<?php

namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\CombatCriteria;
use src\Domain\Entity\Combat;
use src\Repository\CombatRepositoryInterface;

final class CombatReader
{
    public function __construct(
        private CombatRepositoryInterface $combatRepository,
    ) {}

    /**
     * @return ?Combat
     */
    public function combatById(int $id): ?Combat
    {
        return $this->combatRepository->find($id);
    }

    /**
     * @return Collection<Combat>
     */
    public function combatsByUser(int $wpUserId): Collection
    {
        $criteria = new CombatCriteria();
        $criteria->wpUserId = $wpUserId;

        return $this->combatRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<Combat>
     */
    public function activeCombatsByUser(int $wpUserId): Collection
    {
        $criteria = new CombatCriteria();
        $criteria->wpUserId = $wpUserId;
        $criteria->active = 1;

        return $this->combatRepository->findAllWithCriteria($criteria);
    }
}
