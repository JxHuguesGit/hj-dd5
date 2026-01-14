<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Tool as DomainTool;

class Tool extends Repository
{
    public const TABLE = Table::TOOL;
    
    public function getEntityClass(): string
    {
        return DomainTool::class;
    }

    /**
     * Retourne toutes les outils avec les infos issues de item et tool
     */
    public function findAllWithItemAndType(array $criteria=[], array $orderBy=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        $baseQuery = "
            SELECT ".Field::PARENTID."
                , ".Field::NAME.", ".Field::WEIGHT.", ".Field::GOLDPRICE."
            FROM " . Table::TOOL . " t
            INNER JOIN " . Table::ITEM . " i ON i.id = t.id
        ";

        $this->query = $this->queryBuilder->reset()
            ->setBaseQuery($baseQuery)
            ->where($criteria)
            ->orderBy($orderBy)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams()
        );
    }

    public function findByCategory(array $orderBy=[]): Collection
    {
        return $this->findAllWithItemAndType([Field::TYPE=>Constant::CST_TOOL], $orderBy);
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
