<?php
namespace src\Repository;

use src\Domain\Entity\Spell;
use src\Collection\Collection;
use src\Domain\Criteria\SpellCriteria;
use src\Domain\Entity\Classe;

interface SpellRepositoryInterface
{
    /**
     * @return Collection<Spell>
     */
    public function findAll(array $orderBy = []): Collection;

    /**
     * @return Collection<Spell>
     */
    public function findAllWithRelations(SpellCriteria $criteria): Collection;

    /**
     * @return Collection<Classe>
     */
    public function classesBySpellId(int $spellId): Collection;
}
