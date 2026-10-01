<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\SpellEnhancementCriteria;
use src\Domain\Entity\SpellEnhancement;

interface SpellEnhancementRepositoryInterface
{
    /**
     * @return ?SpellEnhancement
     */
    public function find(int $id): ?SpellEnhancement;

    /**
     * @return Collection<SpellEnhancement>
     */
    public function findAllWithCriteria(SpellEnhancementCriteria $criteria): Collection;
}
