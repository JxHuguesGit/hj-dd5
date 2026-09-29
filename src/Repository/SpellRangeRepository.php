<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpellRangeCriteria;
use src\Domain\Entity\SpellRange;

class SpellRangeRepository extends Repository implements SpellRangeRepositoryInterface
{
    public const TABLE = Table::SPELLRANGE;

    public function getEntityClass(): string
    {
        return SpellRange::class;
    }

    /**
     * @return ?SpellRange
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?SpellRange
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SpellRange>
     */
    public function findAllWithCriteria(SpellRangeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
