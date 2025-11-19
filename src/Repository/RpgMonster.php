<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Enum\MonsterTypeEnum;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonster extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgMonster',
            [Field::ID, Field::FRNAME, Field::NAME, Field::FRTAG, Field::UKTAG, Field::INCOMPLET, Field::SCORECR, Field::MSTTYPEID, Field::MSTSSTYPID
            , Field::SWARMSIZE, Field::MSTSIZE, Field::SCORECA, Field::SCOREHP, Field::ALGNID, Field::LEGENDARY, Field::HABITAT, Field::REFID, Field::EXTRA
            , Field::VITESSE, Field::INITIATIVE, Field::STRSCORE, Field::DEXSCORE, Field::CONSCORE, Field::INTSCORE, Field::WISSCORE, Field::CHASCORE
            , Field::PROFBONUS, Field::PERCPASSIVE]
        );
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
        }
        if (isset($criteria['fpMaxFilter'])) {
            $conditions[] = [
                'field' => 'cr',
                'operand' => '<=',
                'value' => $criteria['fpMaxFilter']
            ];
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

        $this->reset();
        $this->query = $this->queryBuilder->reset()
            ->select($this->fields, $this->table)
            ->joinTable($strJoin)
            ->whereComplex($conditions)
            ->orderBy($orderBy)
            ->limit($limit)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->getEntityClass(),
            $this->queryBuilder->getParams(),
            true
        );
    }
}
