<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\SpellRangeCriteria;
use src\Domain\Entity\SpellRange;

interface SpellRangeRepositoryInterface
{
    /**
     * @return ?SpellRange
     */
    public function find(int $id): ?SpellRange;

    /**
     * @return Collection<SpellRange>
     */
    public function findAllWithCriteria(SpellRangeCriteria $criteria): Collection;
}
