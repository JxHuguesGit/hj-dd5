<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\InitiativeTrackerCriteria;
use src\Domain\Entity\InitiativeTracker;

final class InitiativeTrackerRepository extends Repository implements InitiativeTrackerRepositoryInterface
{
    public const TABLE = Table::INITIATIVETRACKER;
    
    public function getEntityClass(): string
    {
        return InitiativeTracker::class;
    }

    /**
     * @return Collection<InitiativeTracker>
     */
    public function findAllWithCriteria(InitiativeTrackerCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
