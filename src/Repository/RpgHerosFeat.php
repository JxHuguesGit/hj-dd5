<?php
namespace src\Repository;

use src\Entity\RpgHerosFeat as EntityRpgHerosFeat;

class RpgHerosFeat extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgHerosFeat::class;
    }
    
    public function findOriginFeat(array $criteria, array $orderBy): EntityRpgHerosFeat
    {
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
    
    public function deleteBy(array $criteria)
    {
        $objs = $this->findBy($criteria);
        foreach ($objs as $obj) {
            $this->delete($obj);
        }
    }
}
