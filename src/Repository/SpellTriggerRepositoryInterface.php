<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\SpellTriggerCriteria;
use src\Domain\Entity\SpellTrigger;

interface SpellTriggerRepositoryInterface
{
    /**
     * @return ?SpellTrigger
     */
    public function find(int $id): ?SpellTrigger;

    /**
     * @return Collection<SpellTrigger>
     */
    public function findAllWithCriteria(SpellTriggerCriteria $criteria): Collection;
}
