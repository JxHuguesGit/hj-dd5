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
        $entityClass = str_replace('Repository', 'Entity', $repositoryClass);
        return $entityClass;
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

    // TODO : Implémenter Update
/*

    public function findOneBy(array $criteria, array $orderBy=[]): ?Entity
    {
        $collection = $this->findBy($criteria, $orderBy, 1);
        return $collection->valid() ? $collection->current() : null;
    }

    public function getDistinct(string $field): array
    {
        return $this->queryBuilder->distinct($field)
            ->orderBy([$field=>ConstantConstant::CST_ASC])
            ->getQuery()
            ->getDistinctResult($field);
    }

    public function getDistinctResult(string $field): array
    {
        global $wpdb;

        $args = [];
        if (isset($this->params[ConstantConstant::CST_ORDERBY])) {
            array_push($args, $this->params[ConstantConstant::CST_ORDERBY]);
        }
        $query = vsprintf($this->query, $args);
        $rows  = $wpdb->get_results($query);

        $results = [];
        while (!empty($rows)) {
            $row = array_shift($rows);
            array_push($results, $row->{$field});
        }
        return $results;
    }

    public function delete(Entity $entity): void
    {
        $this->baseQuery = "DELETE FROM ".$this->table." ";
        foreach ($this->field as $field) {
            $this->params['where'][] = $entity->getField($field);
        }
        $this->getQuery()
            ->execQuery();
    }

    public function execQuery(): void
    {
        global $wpdb;
        $args = [];
        if (isset($this->params['where'])) {
            while (!empty($this->params['where'])) {
                $constraint = array_shift($this->params['where']);
                array_push($args, $constraint);
            }
        }
        $query = vsprintf($this->query, $args);
        $wpdb->query($query);
    }






    public function setCriteriaComplex(array $criteria=[]): self
    {
        if (!empty($criteria)) {
            if ($this->strWhere=='') {
                $this->strWhere = " WHERE 1=1";
                $this->params['where'] = [];
            }
            foreach ($criteria as $crit) {
                $this->strWhere .= " AND `".$crit[ConstantConstant::CST_FIELD]."`".$crit['operand']."'%s'";
                $this->params['where'][] = $crit[ConstantConstant::CST_VALUE];
            }
        }
        return $this;
    }

    public function setCriteria(array $criteria=[]): self
    {
        if (!empty($criteria)) {
            $this->strWhere = " WHERE 1=1";
            $this->params['where'] = [];
            foreach ($criteria as $field => $value) {
                if ($field=='-----') {
                    $this->strWhere .= $value;
                } else {
                    $this->strWhere .= " AND `$field`='%s'";
                    $this->params['where'][] = $value;
                }
            }
        }
        return $this;
    }






    public function convertElement(array $row): mixed
    {
        return $row;
    }
        */
}
