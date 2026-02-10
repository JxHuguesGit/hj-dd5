<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Criteria\ItemCriteria;
use src\Domain\Entity\Item;
use src\Query\QueryBuilder;

class ItemRepository extends Repository implements ItemRepositoryInterface
{
    public const TABLE = Table::ITEM;
    
    public function getEntityClass(): string
    {
        return Item::class;
    }

    /**
     * @return Item
     */
    public function find(int $id): Item
    {
        return parent::find($id) ?? new Item();
    }

    /**
     * @return Collection<DomainItem>
     */
    public function findAllWithItemAndType(
        ItemCriteria $criteria
    ): Collection
    {
        $baseQuery = "
            SELECT id, ".Field::NAME.", ".Field::SLUG.", ".Field::DESCRIPTION.",
                ".Field::WEIGHT.", ".Field::GOLDPRICE.", ".Field::TYPE."
            FROM " . Table::ITEM . " ";

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
