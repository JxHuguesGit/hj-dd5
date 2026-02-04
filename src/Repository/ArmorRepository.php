<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Armor as DomainArmor;
use src\Domain\Criteria\ArmorCriteria;

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
                i.".Field::WEIGHT.", i.".Field::GOLDPRICE."
            FROM " . Table::ARMOR . " a
            INNER JOIN " . Table::ITEM . " i ON i.id = a.id
        ";

        $filters = [];
        if ($criteria->type !== null) {
            $filters[Field::TYPE] = $criteria->type;
        }
        if ($criteria->name !== null) {
            $filters[Field::NAME] = $criteria->name;
        }
        if ($criteria->armorTypeId !== null) {
            $filters[Field::ARMORTYPID] = $criteria->armorTypeId;
        }
        if ($criteria->armorClass !== null) {
            $filters[Field::ARMORCLASS] = $criteria->armorClass;
        }

        $this->query = $this->queryBuilder->reset()
            ->setBaseQuery($baseQuery)
            ->where($filters)
            ->orderBy($criteria->orderBy)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams()
        );
    }
}
