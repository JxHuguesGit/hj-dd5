<?php
namespace src\Repository;

use src\Domain\Entity\Spell;
use src\Collection\Collection;

interface SpellRepositoryInterface
{
    /**
     * @return Collection<Spell>
     */
    public function findAll(array $orderBy = []): Collection;
}
