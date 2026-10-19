<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\InitiativeTrackerCriteria;
use src\Domain\Entity\InitiativeTracker;

interface InitiativeTrackerRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    /**
     * @return Collection<InitiativeTracker>
     */
    public function findAllWithCriteria(InitiativeTrackerCriteria $criteria): Collection;

}
