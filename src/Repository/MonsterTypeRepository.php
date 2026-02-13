<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterTypeCriteria;
use src\Domain\Entity\MonsterType;

class MonsterTypeRepository extends Repository implements MonsterTypeRepositoryInterface
{
    public const TABLE = Table::TYPEMONSTRE;

    public function getEntityClass(): string
    {
        return MonsterType::class;
    }

    /**
     * @return ?MonsterType
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?MonsterType
    {
        return parent::find($id);
    }

    /**
     * @return Collection<MonsterType>
     */
    public function findAllWithCriteria(MonsterTypeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
