<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpellTriggerCriteria;
use src\Domain\Entity\SpellTrigger;

class SpellTriggerRepository extends Repository implements SpellTriggerRepositoryInterface
{
    public const TABLE = Table::SPELLTRIGGER;

    public function getEntityClass(): string
    {
        return SpellTrigger::class;
    }

    /**
     * @return ?SpellTrigger
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?SpellTrigger
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SpellTrigger>
     */
    public function findAllWithCriteria(SpellTriggerCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
