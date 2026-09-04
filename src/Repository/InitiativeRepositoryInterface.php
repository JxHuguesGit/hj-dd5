<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\InitiativeCriteria;
use src\Domain\Entity\Initiative;

interface InitiativeRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function insert(Initiative $initiative): void;
    public function updatePartial(Initiative $initiative, array $changedFields): void;
    public function delete(Initiative $initiative): void;

    /**
     * @return ?Initiative
     */
    public function find(int $id): ?Initiative;

    /**
     * @return Collection<Initiative>
     */
    public function findAllWithCriteria(InitiativeCriteria $criteria): Collection;
}
