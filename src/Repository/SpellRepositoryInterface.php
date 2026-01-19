<?php
namespace src\Repository;

use src\Domain\Spell as DomainSpell;
use src\Collection\Collection;

interface SpellRepositoryInterface
{
    public function find(int $id): ?DomainSpell;
    /**
     * @return Collection<DomainSpell>
     */
    public function findAll(array $orderBy = []): Collection;
}
