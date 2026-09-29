<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpellDurationCriteria;
use src\Domain\Entity\SpellDuration;

class SpellDurationRepository extends Repository implements SpellDurationRepositoryInterface
{
    public const TABLE = Table::SPELLDURATION;

    public function getEntityClass(): string
    {
        return SpellDuration::class;
    }

    /**
     * @return ?SpellDuration
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?SpellDuration
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SpellDuration>
     */
    public function findAllWithCriteria(SpellDurationCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
