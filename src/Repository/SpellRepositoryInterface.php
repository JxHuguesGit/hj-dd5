<?php
namespace src\Repository;

use src\Domain\Entity\Spell;
use src\Collection\Collection;

interface SpellRepositoryInterface
{
    public function find(int $id): ?Spell;
    /**
     * @return Collection<Spell>
     */
    public function findAll(array $orderBy = []): Collection;
}
