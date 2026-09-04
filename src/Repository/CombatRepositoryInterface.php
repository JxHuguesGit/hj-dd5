<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\CombatCriteria;
use src\Domain\Entity\Combat;

interface CombatRepositoryInterface
{
    public function getEntityClass(): string;

    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function insert(Combat $combat): void;
    public function updatePartial(Combat $combat, array $changedFields): void;
    public function delete(Combat $combat): void;

    /**
     * @return ?Combat
     */
    public function find(int $id): ?Combat;

    /**
     * @return Collection<Combat>
     */
    public function findAllWithCriteria(CombatCriteria $criteria): Collection;
}
