<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\CombatCriteria;
use src\Domain\Entity\Combat;

class CombatRepository extends Repository implements CombatRepositoryInterface
{
    public const TABLE = Table::COMBAT;

    public function getEntityClass(): string
    {
        return Combat::class;
    }

    /**
     * @return ?Combat
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Combat
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Combat>
     */
    public function findAllWithCriteria(CombatCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
