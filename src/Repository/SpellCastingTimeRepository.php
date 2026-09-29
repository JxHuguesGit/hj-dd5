<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpellCastingTimeCriteria;
use src\Domain\Entity\SpellCastingTime;

class SpellCastingTimeRepository extends Repository implements SpellCastingTimeRepositoryInterface
{
    public const TABLE = Table::SPELLCASTINGTIME;

    public function getEntityClass(): string
    {
        return SpellCastingTime::class;
    }

    /**
     * @return ?SpellCastingTime
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?SpellCastingTime
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SpellCastingTime>
     */
    public function findAllWithCriteria(SpellCastingTimeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
