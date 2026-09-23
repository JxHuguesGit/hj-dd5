<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field as F;
use src\Constant\Table as T;
use src\Domain\Criteria\ClasseCriteria;
use src\Domain\Entity\Classe;
use src\Query\QueryBuilder;

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

    /**
     * @return Collection<Classe>
     */
    public function allSpellCastingClasses(): Collection
    {
        $baseQuery = "
            SELECT DISTINCT c." . F::ID . ", " . F::NAME . ", " . F::SKILLS . ", " . F::CODE . "
            FROM " . T::RPGCLASSE . " c
                INNER JOIN " . T::SPELLCLASSE . " rsc ON c.id = rsc." . F::CLASSEID . "
            ORDER BY " . F::NAME . " ASC
        ";

        $queryBuilder = new QueryBuilder();
        $queryBuilder->setBaseQuery($baseQuery);

        $this->query = $queryBuilder->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            Classe::class
        );
    }
}
