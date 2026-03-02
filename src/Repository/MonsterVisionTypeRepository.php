<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterVisionTypeCriteria;
use src\Domain\Entity\MonsterVisionType;

class MonsterVisionTypeRepository extends Repository implements MonsterVisionTypeRepositoryInterface
{
    public const TABLE = Table::MSTVISION;

    public function getEntityClass(): string
    {
        return MonsterVisionType::class;
    }

    /**
     * @return Collection<MonsterVisionType>
     */
    public function findAllWithCriteria(MonsterVisionTypeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
