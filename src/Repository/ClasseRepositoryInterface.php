<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\ClasseCriteria;
use src\Domain\Entity\Classe;

interface ClasseRepositoryInterface
{
    /**
     * @return ?Classe
     */
    public function find(int $id): ?Classe;

    /**
     * @return Collection<Classe>
     */
    public function findAllWithCriteria(ClasseCriteria $criteria): Collection;

    /**
     * @return Collection<Classe>
     */
    public function allSpellCastingClasses(): Collection;
}
