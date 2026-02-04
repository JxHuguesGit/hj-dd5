<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Criteria\ItemCriteria;
use src\Domain\Item as DomainItem;

class ItemRepository extends Repository implements ItemRepositoryInterface
{
    public const TABLE = Table::ITEM;
    
    public function getEntityClass(): string
    {
        return DomainItem::class;
    }

    /**
     * @return DomainItem
     */
    public function find(int $id): DomainItem
    {
        return parent::find($id) ?? new DomainItem();
    }

    /**
     * @return Collection<DomainItem>
     */
    public function findAllWithItemAndType(
        ItemCriteria $criteria
    ): Collection
    {
        $baseQuery = "
            SELECT id, ".Field::NAME.", ".Field::SLUG.",
                ".Field::WEIGHT.", ".Field::GOLDPRICE."
            FROM " . Table::ITEM . " ";

        $filters = [];
        if ($criteria->type !== null) {
            $filters[Field::TYPE] = $criteria->type;
        }
        if ($criteria->name !== null) {
            $filters[Field::NAME] = $criteria->name;
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
