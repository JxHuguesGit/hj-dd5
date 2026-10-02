<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\SpellClasseCriteria;
use src\Domain\Entity\SpellClasse;

interface SpellClasseRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function insert(SpellClasse $spellClasse): void;
    public function delete(SpellClasse $spellClasse): void;

    /**
     * @return Collection<SpellClasse>
     */
    public function findAllWithCriteria(SpellClasseCriteria $criteria): Collection;
}
