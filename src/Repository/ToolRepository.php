<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Entity\Tool;
use src\Domain\Criteria\ToolCriteria;

class ToolRepository extends Repository implements ToolRepositoryInterface
{
    public const TABLE = Table::TOOL;
    
    public function getEntityClass(): string
    {
        return Tool::class;
    }

    /**
     * @return ?Tool
     */
    public function find(mixed $id, bool $display=false): ?Tool
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

    /**
     * @return Collection<Tool>
     */
    public function findAll(array $orderBy = []): Collection
    {
        $criteria = new ToolCriteria();
        return $this->findAllWithItemAndType($criteria, $orderBy);
    }

    /**
     * @return Collection<Tool>
     */
    public function findAllWithItemAndType(
        ToolCriteria $criteria
    ): Collection
    {
        $baseQuery = "
            SELECT i.".Field::ID." as ".Field::ID.", ".Field::PARENTID."
                , ".Field::NAME.", ".Field::SLUG.", ".Field::WEIGHT.", ".Field::GOLDPRICE."
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
            ->orderBy($criteria->orderBy)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams()
        );
    }

}
