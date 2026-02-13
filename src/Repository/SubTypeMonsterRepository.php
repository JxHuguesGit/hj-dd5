<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SubTypeMonsterCriteria;
use src\Domain\Entity\SubTypeMonster;

class SubTypeMonsterRepository extends Repository implements SubTypeMonsterRepositoryInterface
{
    public const TABLE = Table::SSTYPEMONSTRE;

    public function getEntityClass(): string
    {
        return SubTypeMonster::class;
    }

    /**
     * @return ?SubTypeMonster
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?SubTypeMonster
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SubTypeMonster>
     */
    public function findAllWithCriteria(SubTypeMonsterCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
