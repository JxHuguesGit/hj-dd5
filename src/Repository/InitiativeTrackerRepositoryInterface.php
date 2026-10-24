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

    public function updatePartial(InitiativeTracker $initTracker, array $changedFields): void;

    /**
     * @return ?InitiativeTracker
     */
    public function find(int $id): ?InitiativeTracker;

    /**
     * @return Collection<InitiativeTracker>
     */
    public function findAllWithCriteria(InitiativeTrackerCriteria $criteria): Collection;

}
