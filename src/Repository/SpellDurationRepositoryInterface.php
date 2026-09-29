<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\SpellDurationCriteria;
use src\Domain\Entity\SpellDuration;

interface SpellDurationRepositoryInterface
{
    /**
     * @return ?SpellDuration
     */
    public function find(int $id): ?SpellDuration;

    /**
     * @return Collection<SpellDuration>
     */
    public function findAllWithCriteria(SpellDurationCriteria $criteria): Collection;
}
