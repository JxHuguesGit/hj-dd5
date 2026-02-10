<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Armor as DomainArmor;
use src\Domain\Criteria\ArmorCriteria;
use src\Query\QueryBuilder;

class ArmorRepository extends Repository implements ArmorRepositoryInterface
{
    public const TABLE = Table::ARMOR;

    public function getEntityClass(): string
    {
        return DomainArmor::class;
    }

    /**
     * @return DomainArmor
     */
    public function find(int $id): DomainArmor
    {
        return parent::find($id) ?? new DomainArmor();
    }

    /**
     * @return Collection<DomainArmor>
     */
    public function findAllWithItemAndType(
        ArmorCriteria $criteria
    ): Collection
    {
        $baseQuery = "
            SELECT a.id, a.".Field::ARMORTYPID.", a.".Field::ARMORCLASS.",
                a.".Field::STRPENALTY.", a.".Field::STHDISADV.",
                i.".Field::NAME.", i.".Field::SLUG." AS ".Field::SLUG.",
                i.".Field::WEIGHT.", i.".Field::GOLDPRICE.", i.".Field::TYPE."
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
