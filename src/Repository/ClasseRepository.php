<?php

namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table as T;
use src\Domain\Criteria\ClasseCriteria;
use src\Domain\Entity\Classe;

class ClasseRepository extends Repository implements ClasseRepositoryInterface
{
    public const TABLE = T::RPGCLASSE;

    public function getEntityClass(): string
    {
        return Classe::class;
    }

    /**
     * @return ?Classe
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Classe
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Classe>
     */
    public function findAllWithCriteria(ClasseCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
