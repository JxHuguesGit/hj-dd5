<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Entity\Entity;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class Repository
{
    protected $query      = '';

    protected $baseQuery  = '';
    protected $strWhere   = '';
    protected $strOrderBy = '';
    protected $strLimit   = '';
    protected $params     = [];

    public function __construct(
        protected QueryBuilder $queryBuilder,
        protected QueryExecutor $queryExecutor,
        protected string $table,
        protected array $fields
    ){

    }

    public function getLastQuery(): string
    {
        return $this->query;
    }

    public function reset(): self
    {
        $this->query = '';
        $this->baseQuery  = '';
        $this->strWhere   = '';
        $this->strOrderBy = '';
        $this->strLimit   = '';
        $this->params     = [];
        return $this;
    }

    public function find(mixed $id): ?Entity
    {
        $this->reset();
        $this->query = $this->queryBuilder->reset()
            ->select($this->fields, $this->table)
            ->where([Field::ID=>$id])
            ->getQuery();
        return $this->queryExecutor->fetchOne(
            $this->query,
            $this->getEntityClass(),
            $this->queryBuilder->getParams()
        );
    }

    public function findBy(array $criteria, array $orderBy=[], int $limit=-1): Collection
    {
        $this->reset();
        $this->query = $this->queryBuilder->reset()
            ->select($this->fields, $this->table)
            ->where($criteria)
            ->orderBy($orderBy)
            ->limit($limit)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->getEntityClass(),
            $this->queryBuilder->getParams()
        );
    }

    public function findAll(array $orderBy=[Field::ID=>Constant::CST_ASC]): Collection
    {
        return $this->findBy([], $orderBy);
    }

    public function getEntityClass(): string
    {
        $repositoryClass = get_class($this);
        return str_replace('Repository', 'Entity', $repositoryClass);
    }

    public function insert(Entity &$entity): void
    {
        $this->reset();
        $this->query = $this->queryBuilder->reset()
            ->getInsertQuery($this->fields, $this->table);

        $values = [];
        foreach ($this->fields as $field) {
            $values[] = $entity->getField($field);
        }
        array_shift($values);
        $insertId = $this->queryExecutor->insert($this->query, $values);

        $entity->setId($insertId);
    }

    public function update(Entity &$entity): void
    {
        $this->reset();
        $this->query = $this->queryBuilder->reset()
            ->getUpdateQuery($this->fields, $this->table);

        $values = [];
        foreach ($this->fields as $field) {
            $values[] = $entity->getField($field);
        }
        $entityId = array_shift($values);
        array_push($values, $entityId);
        $this->queryExecutor->update($this->query, $values);
    }

    public function delete(Entity &$entity): void
    {
        $this->reset();
        $this->query = $this->queryBuilder->reset()
            ->getDeleteQuery($this->table);

        $values = [$entity->getField(Field::ID)];
        $this->queryExecutor->update($this->query, $values);
    }
}
