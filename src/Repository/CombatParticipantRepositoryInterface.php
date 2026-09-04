<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\CombatParticipantCriteria;
use src\Domain\Entity\CombatParticipant;

interface CombatParticipantRepositoryInterface
{
    public function getEntityClass(): string;

    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function insert(CombatParticipant $combatParticipant): void;
    public function updatePartial(CombatParticipant $combatParticipant, array $changedFields): void;
    public function delete(CombatParticipant $combatParticipant): void;

    /**
     * @return ?CombatParticipant
     */
    public function find(int $id): ?CombatParticipant;

    /**
     * @return Collection<CombatParticipant>
     */
    public function findAllWithCriteria(CombatParticipantCriteria $criteria): Collection;
}
