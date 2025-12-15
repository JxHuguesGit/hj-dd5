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
    // Valeur par défaut
    public const TABLE = '';

    protected string $query = '';
    protected string $table;
    protected array $fields;
    
    public function __construct(
        protected QueryBuilder $queryBuilder,
        protected QueryExecutor $queryExecutor,
        ?string $table = null,
        ?array $fields = null
    ) {
        $entityClass = $this->getEntityClass();

        if ($entityClass !== null) {
            // Ancien comportement : récupération des champs depuis l'entité
            $this->fields = $entityClass::FIELDS;

            // Pour la table, on préfère la constante static::TABLE si elle existe
            if (defined('static::TABLE') && static::TABLE!='') {
                $this->table = static::TABLE;
            } elseif ($table !== null) {
                $this->table = $table;
            } else {
                $entityClass = $this->getEntityClass();
                if ($entityClass!==null) {
                    $this->table = $entityClass::TABLE;
                    $this->fields = $entityClass::FIELDS;
                } else {
                    throw new \LogicException("Le Repository " . static::class . " doit définir une table.");
                }
            }
        } else {
            // Ancien Repository qui ne retourne pas d'entité Domain
            $this->table = $table ?? '';
            $this->fields = $fields ?? [];
        }
    }

    public function find(mixed $id, bool $display=false): ?object
    {
        $this->query = $this->queryBuilder->reset()
            ->select($this->fields, $this->table)
            ->where([Field::ID=>$id])
            ->getQuery();
        return $this->queryExecutor->fetchOne(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams(),
            $display
        );
    }

    public function findAll(array $orderBy=[Field::ID=>Constant::CST_ASC], bool $display=false): Collection
    {
        return $this->findBy([], $orderBy, -1, $display);
    }

    public function findBy(array $criteria, array $orderBy=[], int $limit=-1, bool $display=false): Collection
    {
        $this->query = $this->queryBuilder->reset()
            ->select($this->fields, $this->table)
            ->where($criteria)
            ->orderBy($orderBy)
            ->limit($limit)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams(),
            $display
        );
    }
    
    public function findByComplex(array $criteriaComplex, array $orderBy=[], int $limit=-1, bool $display=false): Collection
    {
        $this->query = $this->queryBuilder->reset()
            ->select($this->fields, $this->table)
            ->whereComplex($criteriaComplex)
            ->orderBy($orderBy)
            ->limit($limit)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams(),
            $display
        );
    }
    
    protected function resolveEntityClass(): string
    {
        $entityClass = $this->getEntityClass();

        // Si la classe fille n'a pas encore migré → fallback
        if (!$entityClass) {
            // Ancienne règle d’inférence : remplacer Repository par Entity
            return str_replace('Repository', 'Entity', get_class($this));
        }

        return $entityClass;
    }

    public function getEntityClass(): ?string
    {
        return null;
    }

    protected function getEntityValues(Entity $entity, bool $skipId = false): array
    {
        $values = [];
        foreach ($this->fields as $field) {
            if ($skipId && $field === Field::ID) {
                continue;
            }
            $values[] = $entity->getField($field);
        }
        return $values;
    }

    protected function getEntityId(Entity $entity): mixed
    {
        return $entity->getField(Field::ID);
    }

    public function insert(Entity $entity): void
    {
        $this->query = $this->queryBuilder->reset()
            ->getInsertQuery($this->fields, $this->table);

        $values = $this->getEntityValues($entity, true);
        $insertId = $this->queryExecutor->insert($this->query, $values);
        $entity->assignId($insertId);
    }

    public function update(Entity $entity): void
    {
        $this->query = $this->queryBuilder->reset()
            ->getUpdateQuery($this->fields, $this->table);

        $values = $this->getEntityValues($entity, true);
        $values[] = $this->getEntityId($entity);
        $this->queryExecutor->update($this->query, $values);
    }

    public function delete(Entity $entity): void
    {
        $this->query = $this->queryBuilder->reset()
            ->getDeleteQuery($this->table);

        $this->queryExecutor->update($this->query, [$this->getEntityId($entity)]);
    }
}
