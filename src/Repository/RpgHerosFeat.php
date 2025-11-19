<?php
namespace src\Repository;

use src\Constant\Field;
use src\Entity\RpgHerosFeat as EntityRpgHerosFeat;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgHerosFeat extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgHerosFeat',
            [Field::ID, Field::HEROSID, Field::FEATID, Field::EXTRA]
        );
    }

    public function findOriginFeat(array $criteria, array $orderBy): EntityRpgHerosFeat
    {
        $this->reset();
        $this->query = $this->queryBuilder->reset()
            ->select($this->fields, $this->table)
            ->where($criteria)
            ->orderBy($orderBy)
            ->limit(1)
            ->getQuery();

        $objRpgHerosFeat = $this->queryExecutor->fetchOne(
            $this->query,
            $this->getEntityClass(),
            $this->queryBuilder->getParams()
        );

        return $objRpgHerosFeat ?? new EntityRpgHerosFeat(...[0, 0, 0, 0]);
    }
}
