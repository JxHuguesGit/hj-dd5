<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SousTypeMonsterCriteria;
use src\Domain\Entity\SousTypeMonster;

class SousTypeMonsterRepository extends Repository implements SousTypeMonsterRepositoryInterface
{
    public const TABLE = Table::SSTYPEMONSTRE;

    public function getEntityClass(): string
    {
        return SousTypeMonster::class;
    }

    /**
     * @return SousTypeMonster
     */
    public function find(int $id): SousTypeMonster
    {
        return parent::find($id) ?? new SousTypeMonster();
    }

    /**
     * @return Collection<SousTypeMonster>
     */
    public function findAllWithCriteria(
        SousTypeMonsterCriteria $criteria
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
