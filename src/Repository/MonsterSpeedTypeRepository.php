<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterSpeedTypeCriteria;
use src\Domain\Entity\MonsterSpeedType;

class MonsterSpeedTypeRepository extends Repository implements MonsterSpeedTypeRepositoryInterface
{
    public const TABLE = Table::MSTSPEED;

    public function getEntityClass(): string
    {
        return MonsterSpeedType::class;
    }

    /**
     * @return Collection<MonsterSpeed>
     */
    public function findAllWithCriteria(MonsterSpeedTypeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
