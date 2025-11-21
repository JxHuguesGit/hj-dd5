<?php
namespace src\Repository;

use src\Entity\RpgMonster as EntityRpgMonster;
use src\Collection\Collection;
use src\Constant\Field;
use src\Enum\MonsterTypeEnum;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonster extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgMonster::class;
    }
    
    public function findBy(array $criteria, array $orderBy=[], int $limit=-1): Collection
    {
        $conditions = [];
        if (isset($criteria['fpMinFilter'])) {
            $conditions[] = [
                'field' => 'cr',
                'operand' => '>=',
                'value' => $criteria['fpMinFilter']
            ];
            unset($criteria['fpMinFilter']);
        }
        if (isset($criteria['fpMaxFilter'])) {
            $conditions[] = [
                'field' => 'cr',
                'operand' => '<=',
                'value' => $criteria['fpMaxFilter']
            ];
            unset($criteria['fpMaxFilter']);
        }
        if (isset($criteria['typeFilter']) && $criteria['typeFilter']!='' && count($criteria['typeFilter'])!=14) {
            $typeNames = [];
            foreach ($criteria['typeFilter'] as $key) {
                $typeNames[] = $key;
            }
            $strJoin = " JOIN rpgMonsterType mt ON rpgMonster.monstreTypeId = mt.id AND abbr IN ('".implode("', '", $typeNames)."')";
        } else {
            $strJoin = '';
        }
        
        foreach (['page', 'onglet', 'id', 'selectAllType', 'typeFilter'] as $key) {
            if (isset($criteria[$key])) {
                unset($criteria[$key]);
            }
        }

        $this->query = $this->queryBuilder->reset()
            ->select($this->fields, $this->table)
            ->joinTable($strJoin)
            ->where($criteria)
            ->whereComplex($conditions)
            ->orderBy($orderBy)
            ->limit($limit)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams()
        );
    }
}
