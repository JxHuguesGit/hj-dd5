<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\FeatTypeCriteria;
use src\Domain\Entity\FeatType;

class FeatTypeRepository extends Repository implements FeatTypeRepositoryInterface
{
    public const TABLE = Table::FEATTYPE;

    public function getEntityClass(): string
    {
        return FeatType::class;
    }

    /**
     * @return ?FeatType
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?FeatType
    {
        return parent::find($id);
    }

    /**
     * @return Collection<FeatType>
     */
    public function findAllWithCriteria(FeatTypeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
