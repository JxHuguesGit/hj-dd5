<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field as F;
use src\Constant\Table;
use src\Domain\Entity\Tool;
use src\Domain\Criteria\ToolCriteria;
use src\Query\QueryBuilder;

class ToolRepository extends Repository implements ToolRepositoryInterface
{
    public const TABLE = Table::TOOL;

    public function getEntityClass(): string
    {
        return Tool::class;
    }

    /**
     * @return ?Tool
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Tool
    {
        return parent::find($id);
    }

    /**
     * @return ?Tool
     */
    public function findWithRelations(int $id): ?Tool
    {
        $criteria = new ToolCriteria();
        $criteria->id = $id;
        return $this->findAllWithRelations($criteria)->first() ?? null;
    }

    /**
     * @return Collection<Tool>
     */
    public function findAllWithRelations(ToolCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT i.".F::ID." as ".F::ID.", ".F::PARENTID."
                , i.".F::NAME.", i.".F::SLUG.", i.".F::WEIGHT.", i.".F::GOLDPRICE."
                , i2.".F::NAME." as ".F::PARENTNAME."
            FROM " . Table::TOOL . " t
            INNER JOIN " . Table::ITEM . " i ON i.id = t.id
            LEFT JOIN " . Table::ITEM . " i2 ON i2.id = parentId
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
