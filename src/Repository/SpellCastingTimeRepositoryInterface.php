<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\SpellCastingTimeCriteria;
use src\Domain\Entity\SpellCastingTime;

interface SpellCastingTimeRepositoryInterface
{
    /**
     * @return ?SpellCastingTime
     */
    public function find(int $id): ?SpellCastingTime;

    /**
     * @return Collection<SpellCastingTime>
     */
    public function findAllWithCriteria(SpellCastingTimeCriteria $criteria): Collection;
}
