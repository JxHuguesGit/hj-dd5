<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpeedTypeCriteria;
use src\Domain\Entity\SpeedType;

class SpeedTypeRepository extends Repository implements SpeedTypeRepositoryInterface
{
    public const TABLE = Table::SPEEDTYPE;
    
    public function getEntityClass(): string
    {
        return SpeedType::class;
    }

    /**
     * @return SpeedType
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): SpeedType
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SpeedType>
     */
    public function findAllWithCriteria(SpeedTypeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
