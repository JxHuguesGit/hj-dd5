<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field as F;
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
     * @return ?Item
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Item
    {
        return parent::find($id);
    }

    /**
     * @return ?Item
     */
    public function findWithRelations(int $id): ?Item
    {
        $criteria = new ItemCriteria();
        $criteria->id = $id;
        return $this->findAllWithRelations($criteria)->first() ?? null;
    }

    /**
     * @return Collection<Item>
     */
    public function findAllWithRelations(ItemCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT i.".F::ID." as ".F::ID.", i.".F::NAME." AS ".F::NAME.", i.".F::SLUG." as ".F::SLUG."
                , i.".F::DESCRIPTION." as ".F::DESCRIPTION.", i.".F::WEIGHT." as ".F::WEIGHT."
                , i.".F::GOLDPRICE." as ".F::GOLDPRICE.", i.".F::TYPE." as ".F::TYPE."
                , i2.".F::NAME." as ".F::BUILDNAME." , i2.".F::SLUG." as ".F::BUILDSLUG."
            FROM " . Table::ITEM . " i
            LEFT JOIN " . Table::ITEM . " i2 ON i.toolId = i2.id
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
