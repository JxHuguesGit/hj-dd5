<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\VisionTypeCriteria;
use src\Domain\Entity\VisionType;

class VisionTypeRepository extends Repository implements VisionTypeRepositoryInterface
{
    public const TABLE = Table::VISIONTYPE;

    public function getEntityClass(): string
    {
        return VisionType::class;
    }

    /**
     * @return VisionType
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): VisionType
    {
        return parent::find($id);
    }

    /**
     * @return Collection<VisionType>
     */
    public function findAllWithCriteria(VisionTypeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
