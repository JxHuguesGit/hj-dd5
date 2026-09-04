<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\CombatParticipantCriteria;
use src\Domain\Entity\CombatParticipant;

class CombatParticipantRepository extends Repository implements CombatParticipantRepositoryInterface
{
    public const TABLE = Table::COMBAT_PARTICIPANT;

    public function getEntityClass(): string
    {
        return CombatParticipant::class;
    }

    /**
     * @return ?CombatParticipant
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?CombatParticipant
    {
        return parent::find($id);
    }

    /**
     * @return Collection<CombatParticipant>
     */
    public function findAllWithCriteria(
        CombatParticipantCriteria $criteria
    ): Collection {
        return $this->findAllByCriteria($criteria);
    }
}
