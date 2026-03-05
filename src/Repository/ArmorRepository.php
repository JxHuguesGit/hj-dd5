<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field as F;
use src\Constant\Table;
use src\Domain\Entity\Armor;
use src\Domain\Criteria\ArmorCriteria;
use src\Query\QueryBuilder;

class ArmorRepository extends Repository implements ArmorRepositoryInterface
{
    public const TABLE = Table::ARMOR;

    public function getEntityClass(): string
    {
        return Armor::class;
    }

    /**
     * @return ?Armor
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Armor
    {
        return parent::find($id);
    }

    /**
     * @return ?Armor
     */
    public function findWithRelations(int $id): ?Armor
    {
        $criteria = new ArmorCriteria();
        $criteria->id = $id;
        return $this->findAllWithRelations($criteria)->first() ?? null;
    }

    /**
     * @return Collection<Armor>
     */
    public function findAllWithRelations(ArmorCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT a.id, a.".F::ARMORTYPID.", a.".F::ARMORCLASS.",
                a.".F::STRPENALTY.", a.".F::STHDISADV.",
                i.".F::NAME.", i.".F::SLUG." AS ".F::SLUG.",
                i.".F::WEIGHT.", i.".F::GOLDPRICE.", i.".F::TYPE."
            FROM " . Table::ARMOR . " a
            INNER JOIN " . Table::ITEM . " i ON i.id = a.id
        ";

        $queryBuilder = new QueryBuilder();
        $queryBuilder->setBaseQuery($baseQuery);
        $criteria->apply($queryBuilder);

        $this->query = $queryBuilder
            ->orderBy($criteria->orderBy)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $queryBuilder->getParams()
        );
    }
}
