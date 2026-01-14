<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Tool as DomainTool;
use src\Domain\Criteria\ToolCriteria;

class ToolRepository extends Repository implements ToolRepositoryInterface
{
    public const TABLE = Table::TOOL;
    
    public function getEntityClass(): string
    {
        return DomainTool::class;
    }

    /**
     * @return Collection<DomainTool>
     */
    public function findAll(array $orderBy = []): Collection
    {
        $criteria = new ToolCriteria();
        return $this->findAllWithItemAndType($criteria, $orderBy);
    }

    /**
     * @return Collection<DomainTool>
     */
    public function findAllWithItemAndType(
        ToolCriteria $criteria,
        array $orderBy=[Field::NAME=>Constant::CST_ASC]
    ): Collection
    {
        $baseQuery = "
            SELECT ".Field::PARENTID."
                , ".Field::NAME.", ".Field::WEIGHT.", ".Field::GOLDPRICE."
            FROM " . Table::TOOL . " t
            INNER JOIN " . Table::ITEM . " i ON i.id = t.id
        ";

        $filters = [];
        if ($criteria->type !== null) {
            $filters[Field::TYPE] = $criteria->type;
        }

        $this->query = $this->queryBuilder->reset()
            ->setBaseQuery($baseQuery)
            ->where($filters)
            ->orderBy($orderBy)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams()
        );
    }

    /**
     * @return Collection<DomainTool>
     */
    public function findByCategory(array $orderBy=[]): Collection
    {
        $criteria = new ToolCriteria();
        $criteria->type = Constant::CST_TOOL;
        return $this->findAllWithItemAndType($criteria, $orderBy);
    }

    public function find(mixed $id, bool $display=false): ?object
    {
        $baseQuery = "
            SELECT ".Field::PARENTID."
                , ".Field::NAME.", ".Field::SLUG.", ".Field::WEIGHT.", ".Field::GOLDPRICE."
            FROM " . Table::TOOL . " t
            INNER JOIN " . Table::ITEM . " i ON i.id = t.id
            WHERE i.id = " . $id
        ;

        $this->query = $this->queryBuilder->reset()
            ->setBaseQuery($baseQuery)
            ->getQuery();

        return $this->queryExecutor->fetchOne(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams(),
            $display
        );
    }
}
