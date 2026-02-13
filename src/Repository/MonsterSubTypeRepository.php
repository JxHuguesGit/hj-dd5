<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterSubTypeCriteria;
use src\Domain\Entity\MonsterSubType;

class MonsterSubTypeRepository extends Repository implements MonsterSubTypeRepositoryInterface
{
    public const TABLE = Table::SSTYPEMONSTRE;

    public function getEntityClass(): string
    {
        return MonsterSubType::class;
    }

    /**
     * @return ?MonsterSubType
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?MonsterSubType
    {
        return parent::find($id);
    }

    /**
     * @return Collection<MonsterSubType>
     */
    public function findAllWithCriteria(MonsterSubTypeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
