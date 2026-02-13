<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\FeatCriteria;
use src\Domain\Entity\Feat;

class FeatRepository extends Repository implements FeatRepositoryInterface
{
    public const TABLE = Table::FEAT;
    
    public function getEntityClass(): string
    {
        return Feat::class;
    }

    /**
     * @return ?Feat
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Feat
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Feat>
     */
    public function findAllWithCriteria(FeatCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
