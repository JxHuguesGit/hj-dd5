<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\FeatPreRequisCriteria;
use src\Domain\Entity\FeatPreRequis;

class FeatPreRequisRepository extends Repository implements FeatPreRequisRepositoryInterface
{
    public const TABLE = Table::FEATPREREQUIS;

    public function getEntityClass(): string
    {
        return FeatPreRequis::class;
    }

    /**
     * @return Collection<FeatPreRequis>
     */
    public function findAllWithCriteria(FeatPreRequisCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
